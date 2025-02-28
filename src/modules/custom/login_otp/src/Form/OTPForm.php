<?php

namespace Drupal\login_otp\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Component\Utility\Random;
use Drupal\login_otp\Service\EmailHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Language\LanguageManagerInterface;

/**
 * Class OTPForm
 */
class OTPForm extends FormBase
{

    protected $emailHelper;
    protected $tempStore;
    protected $currentUser;
    protected $languageManager;

    public function __construct(
        EmailHelper              $email_helper,
        PrivateTempStoreFactory  $temp_store,
        AccountProxyInterface    $current_user,
        LanguageManagerInterface $language_manager)
    {
        $this->emailHelper = $email_helper;
        $this->tempStore = $temp_store->get('login_otp');
        $this->currentUser = $current_user;
        $this->languageManager = $language_manager;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('login_otp.email_helper'),
            $container->get('tempstore.private'),
            $container->get('current_user'),
            $container->get('language_manager')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'login_otp_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // Prevent logged-in users from accessing the OTP login form.
        if ($this->currentUser->isAuthenticated()) {
            \Drupal::messenger()->addStatus($this->t('You are already logged in.'));
            return [];
        }

        $step = $form_state->get('step') ?? 'email';

        $form['#attributes']['class'] = ['container', 'p-4', 'shadow', 'rounded', 'bg-light','mb-4'];

        if ($step === 'email') {
            $form['email'] = [
                '#type' => 'email',
                '#title' => $this->t('Enter your email'),
                '#required' => TRUE,
                '#attributes' => ['class' => ['form-control', 'mb-3']], // Added margin-bottom
            ];
        } else {
            $form['otp'] = [
                '#type' => 'textfield',
                '#title' => $this->t('Enter OTP'),
                '#required' => TRUE,
                '#attributes' => ['class' => ['form-control', 'text-center', 'fw-bold', 'mb-3']], // Added margin-bottom
            ];
            $form['resend'] = [
                '#type' => 'submit',
                '#value' => $this->t('Resend OTP'),
                '#attributes' => ['class' => ['btn', 'btn-warning', 'w-100', 'mb-3']], // Added margin-bottom
                '#submit' => ['::resendOTP'],
            ];
        }

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t($step === 'email' ? 'Send OTP' : 'Verify OTP'),
            '#attributes' => ['class' => ['btn', 'btn-primary', 'w-100']],
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $step = $form_state->get('step') ?? 'email';

        if ($step === 'email') {
            $email = $form_state->getValue('email');

            $otp = random_int(100000, 999999); // Generate 6-digit random number
            $expires = time() + 60; // OTP expires in 60 seconds

            $this->tempStore->set('otp_' . $email, ['otp' => $otp, 'expires' => $expires]);

            $subject = $this->t('Your One-Time Password (OTP)');
            $message = $this->t('<p>Your OTP is: <strong>@otp</strong></p><p>This OTP expires in <strong>60 seconds</strong>.</p>', ['@otp' => $otp]);

            $this->emailHelper->sendEmail($email, $subject, $message);

            \Drupal::messenger()->addStatus($this->t('OTP sent to @email. It expires in 60 seconds.', ['@email' => $email]));

            $form_state->set('step', 'otp');
            $form_state->set('email', $email);
            $form_state->setRebuild();
        } else {
            $email = $form_state->get('email');
            $entered_otp = $form_state->getValue('otp');
            $stored = $this->tempStore->get('otp_' . $email);

            if ($stored && time() < $stored['expires'] && $entered_otp == $stored['otp']) {
                \Drupal::messenger()->addStatus($this->t('OTP verified successfully!'));
                $this->tempStore->delete('otp_' . $email);
            } else {
                \Drupal::messenger()->addError($this->t('Invalid or expired OTP. Please try again.'));
            }
        }
    }

    public function resendOTP(array &$form, FormStateInterface $form_state)
    {
        $email = $form_state->get('email');

        $otp = random_int(100000, 999999); // Generate new OTP
        $expires = time() + 60; // Expiry in 60s

        $this->tempStore->set('otp_' . $email, ['otp' => $otp, 'expires' => $expires]);

        $subject = $this->t('Your New OTP');
        $message = $this->t('<p>Your new OTP is: <strong>@otp</strong></p><p>This OTP expires in <strong>60 seconds</strong>.</p>', ['@otp' => $otp]);

        $this->emailHelper->sendEmail($email, $subject, $message);

        \Drupal::messenger()->addStatus($this->t('New OTP sent to @email.', ['@email' => $email]));
        $form_state->setRebuild();
    }
}
