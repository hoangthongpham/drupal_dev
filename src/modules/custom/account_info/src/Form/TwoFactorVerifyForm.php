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
    if (!isset($_SESSION['tfa_user_id'])) {
      \Drupal::messenger()->addError(t('Session expired. Please login again.'));
      $form_state->setRedirect('custom_auth.login_form');
      return [];
    }

    $form['otp'] = [
      '#type' => 'textfield',
      '#title' => t('Enter OTP'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Verify OTP'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $otp = $form_state->getValue('otp');
    $user_id = $_SESSION['tfa_user_id'];
    $user = User::load($user_id);

    // Lấy secret key từ user (lưu trong field_tfa_secret)
    $secret_key = $user->get('field_tfa_secret')->value;
    $totp = TOTP::create($secret_key);

    if ($totp->verify($otp)) {
      // Xác thực thành công, login user
      user_login_finalize($user);
      \Drupal::messenger()->addStatus(t('Login successful!'));

      // Xóa session để tránh lạm dụng
      unset($_SESSION['tfa_user_id']);

      $form_state->setRedirect('<front>');
    } else {
      \Drupal::messenger()->addError(t('Invalid OTP. Please try again.'));
    }
  }
}
