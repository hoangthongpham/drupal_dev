<?php

namespace Drupal\homepage\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\user\Entity\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Provides an OTP-only login form.
 */
class OtpLoginForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'otp_only_login_form';
    }

    /**
     * Builds the OTP login form.
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $session = \Drupal::request()->getSession();
        $otp_step = $session->get('otp_step', 'email');
        $otp_step_expires = $session->get('otp_step_expires', 0);

        // ✅ If expired, reset to 'email' step
        if ($otp_step === 'otp' && time() > $otp_step_expires) {
            $otp_step = 'email';
            $session->remove('otp_step');
            $session->remove('otp_step_expires');
            \Drupal::messenger()->addError($this->t('OTP has expired. Please request a new one.'));
        }

        $form['#prefix'] = '<div id="otp-login-form">';
        $form['#suffix'] = '</div>';

        if ($otp_step === 'email') {
            // Show Email Field and Send OTP Button
            $form['email'] = [
                '#type' => 'email',
                '#title' => $this->t('Email'),
                '#required' => TRUE,
                '#attributes' => ['autocomplete' => 'off'],
            ];

            $form['send_otp'] = [
                '#type' => 'submit',
                '#value' => $this->t('Send OTP'),
                '#submit' => ['::sendOtp'],
            ];
        } else {
            // Show OTP Field and Submit Button
            $form['otp'] = [
                '#type' => 'textfield',
                '#title' => $this->t('Enter OTP'),
                '#attributes' => ['autocomplete' => 'off'],
            ];

            $form['submit'] = [
                '#type' => 'submit',
                '#value' => $this->t('Login'),
            ];
        }

        return $form;
    }


    /**
     * Sends an OTP to the user's email.
     */
    public function sendOtp(array &$form, FormStateInterface $form_state) {
        $email = $form_state->getValue('email');

        if (!$email) {
            $form_state->setErrorByName('email', $this->t('Please enter your email.'));
            return;
        }

        $user = user_load_by_mail($email);
        if (!$user) {
            $form_state->setErrorByName('email', $this->t('Email not found.'));
            return;
        }

        $otp = rand(100000, 999999); // Generate 6-digit OTP
        $expiry_time = time() + (2 * 60); // 2 minutes from now

        // Store OTP and expiry in session
        \Drupal::request()->getSession()->set('otp_' . $email, [
            'code' => $otp,
            'expires' => $expiry_time,
        ]);

        $session = \Drupal::request()->getSession();
        $session->set('otp_step', 'otp');
        $session->set('otp_step_expires', $expiry_time);
        $session->set('otp_email', $email);

        // Send OTP via email
        homepage_send_email($email, 'Your OTP Code', "<p>Your OTP for login is: <strong>$otp</strong></p>");

        // ✅ Add success message
        \Drupal::messenger()->addStatus($this->t('OTP sent to @email. It will expire in 2 minutes.', ['@email' => $email]));
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $session = \Drupal::request()->getSession();
        $otpStep = $session->get('otp_step');
        if($otpStep == 'otp') {
            $email = $session->get('otp_email');
            $entered_otp = $form_state->getValue('otp');

            $user = user_load_by_mail($email);
            if (!$user) {
                \Drupal::messenger()->addStatus($this->t('Invalid email.'));
                $form_state->setErrorByName('email', $this->t('Invalid email.'));
                return;
            }

            // Check OTP
            $stored_otp = \Drupal::request()->getSession()->get('otp_' . $email);
            if (isset($stored_otp['code']) && $entered_otp != $stored_otp['code']) {
                \Drupal::messenger()->addStatus($this->t('Invalid OTP.'));
                $form_state->setErrorByName('otp', $this->t('Invalid OTP.'));
                return;
            }
        }
    }
    /**
     * Handles OTP login.
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $session = \Drupal::request()->getSession();
        $email = $session->get('otp_email');
        $entered_otp = $form_state->getValue('otp');

        $user = user_load_by_mail($email);
        // Log in the user
        user_login_finalize($user);

        // Clear OTP session
        $session->remove('otp_' . $email);
        $session->remove('otp_step');
        $session->remove('otp_email');
        $session->remove('otp_step_expires');

        \Drupal::messenger()->addStatus($this->t('Login successful.'));
        $form_state->setRedirect('<front>');
    }

    public function ajaxReloadForm(array &$form, FormStateInterface $form_state) {
        \Drupal::messenger()->addStatus($this->t('Login successful.'));
    }

    /**
     * AJAX callback to display OTP sent message.
     */
    public function ajaxOtpSentMessage(array &$form, FormStateInterface $form_state) {
        return [
            '#markup' => '<div id="otp-message" class="message-success">' . $this->t('OTP sent to your email.') . '</div>',
        ];
    }
}
