<?php

namespace Drupal\account_info\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use OTPHP\TOTP;

class TwoFactorVerifyForm extends FormBase
{

  public function getFormId()
  {
    return 'account_info_2fa_verify_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['otp_code'] = [
      '#type' => 'textfield',
      '#title' => 'Enter OTP Code',
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Verify',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $entered_otp = $form_state->getValue('otp_code');
    $user = \Drupal::currentUser();
    $user_entity = User::load($user->id());

    $secret = $user_entity->get('field_2fa_secret')->value;
    $totp = TOTP::create($secret);

    if ($totp->verify($entered_otp)) {
      \Drupal::messenger()->addMessage('2FA verification successful.');
      return new RedirectResponse('/');
    } else {
      \Drupal::messenger()->addError('Invalid OTP code.');
    }
  }
}
