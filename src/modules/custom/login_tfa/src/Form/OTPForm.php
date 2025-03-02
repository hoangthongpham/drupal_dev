<?php

namespace Drupal\login_tfa\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\login_tfa\Service\EmailHelper;
use Drupal\user\Entity\User;

class OTPForm extends FormBase
{
  protected $emailHelper;
  protected $tempStore;

  public function __construct(
    EmailHelper $email_helper,
    PrivateTempStoreFactory $tempStoreFactory)
  {
    $this->emailHelper = $email_helper;
    $this->tempStore = $tempStoreFactory->get('login_tfa');
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('login_tfa.email_helper'),
      $container->get('tempstore.private')
    );
  }

  public function getFormId()
  {
    return 'otp_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $expires = $this->tempStore->get('expires');
    
    $step = $this->tempStore->get('step') ?? 'email';
    if (time() > $expires) {
      $step = 'email';
    }

    $form['#prefix'] = '<div id="otp-form-wrapper">';
    $form['#suffix'] = '</div>';
    $form['#attributes']['class'] = ['container', 'p-4','mb-4', 'shadow', 'rounded', 'bg-light'];
    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div id="otp-message"></div>',
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Enter your email'),
      '#attributes' => ['class' => ['form-control', 'mb-3']],
    ];
    
    $form['otp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter OTP'),
      '#attributes' => ['class' => ['form-control', 'fw-bold', 'mb-3']],
    ];

    $form['resend'] = [
      '#prefix' => '<div class="row"><div class="col-2">',
      '#type' => 'submit',
      '#value' => $this->t($step === 'email' ? 'Send OTP' : 'Verify OTP'),
      '#attributes' => ['class' => ['btn', 'btn-primary', 'w-100']],
      '#ajax' => ['callback' => '::submitAjax'],
      '#suffix' => '</div>'
    ];
    if ($step != 'email') {
      $form['submit'] = [
        '#prefix' => '<div class="col-2">',
        '#type' => 'submit',
        '#value' => $this->t('Resend OTP'),
        '#attributes' => ['class' => ['btn', 'btn-warning', 'w-100', 'mb-3']],
        '#ajax' => ['callback' => '::resendOTP'],
        '#suffix' => '</div></div>'
      ];
    }
    return $form;
  }

  public function submitAjax(array &$form, FormStateInterface $form_state)
  {
    $response = new AjaxResponse();
    $step = $this->tempStore->get('step') ?? 'email';
    var_dump($step);
    die;

    $response->addCommand(new HtmlCommand('#otp-message', '<div class="alert alert-info">Processing...</div>'));
    if ($step === 'email') {
      $email = $form_state->getValue('email');
      $otp = rand(100000, 999999);
      // Lưu vào TempStore từng giá trị một
      $this->tempStore->set('otp', $otp);
      $this->tempStore->set('email', $email);
      $this->tempStore->set('expires', time() + 60);
      $this->tempStore->set('step', 'otp');

      $this->sendOTPEmail($email, $otp);
      $response->addCommand(new HtmlCommand('#otp-message', '<div class="alert alert-success">OTP has been sent!</div>'));
    } else {
      $enteredOtp = $form_state->getValue('otp');
      $storedOtp = $this->tempStore->get('otp');
      $email = $this->tempStore->get('email');
      $expires = $this->tempStore->get('expires');

      if ($storedOtp && $enteredOtp == $storedOtp && time() < $expires) {
        $this->loginUserByEmail($email);
        $response->addCommand(new HtmlCommand('#otp-message', '<div class="alert alert-success">Login successful!</div>'));
        $this->tempStore->delete('step');
      } else {
        $response->addCommand(new HtmlCommand('#otp-message', '<div class="alert alert-danger">Invalid or expired OTP.</div>'));
      }
    }

    $response->addCommand(new ReplaceCommand('#otp-form-wrapper', $form));
    return $response;
  }

  public function resendOTP(array &$form, FormStateInterface $form_state)
  {
    $response = new AjaxResponse();
    $email = $this->tempStore->get('email');

    if ($email) {
      $otp = rand(100000, 999999);
      // Lưu OTP mới vào TempStore
      $this->tempStore->set('otp', $otp);
      $this->tempStore->set('expires', time() + 60);

      $this->sendOTPEmail($email, $otp);
      $response->addCommand(new HtmlCommand('#otp-message', '<div class="alert alert-success">New OTP sent!</div>'));
    } else {
      $response->addCommand(new HtmlCommand('#otp-message', '<div class="alert alert-danger">No email found.</div>'));
    }

    return $response;
  }

  private function sendOTPEmail($to, $otp)
  {
    $mailManager = \Drupal::service('plugin.manager.mail');
    $module = 'mymodule';
    $key = 'otp_verification';
    $params['message'] = t('Your OTP is: ') . $otp;
    $params['subject'] = t('Your One-Time Password (OTP)');
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $send = TRUE;
    $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
  }

  private function loginUserByEmail($email)
  {
    $user_storage = \Drupal::entityTypeManager()->getStorage('user');
    $users = $user_storage->loadByProperties(['mail' => $email]);
    if ($user = reset($users)) {
      user_login_finalize($user);
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
  }
}
