<?php

namespace Drupal\login_tfa\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class LoginTfaForm extends FormBase
{

  public function getFormId()
  {
    return 'login_tfa_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['#prefix'] = '<div id="otp-form-wrapper">';
    $form['#suffix'] = '</div>';
    $form['#attributes']['class'] = ['container', 'p-4', 'mb-4', 'shadow', 'rounded', 'bg-light'];
    // step 1: Input Username and Password
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('email'),
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Login'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Verify username and password
    $email = $form_state->getValue('email');
    $password = $form_state->getValue('password');

    // Kiểm tra user tồn tại
    $users = \Drupal::entityTypeManager()->getStorage('user')->loadByProperties(['mail' => $email]);
    if (empty($users)) {
      \Drupal::messenger()->addError(t('Invalid email or password.'));
      return;
    }

    $user = reset($users);

    // Xác thực mật khẩu
    if (!\Drupal::service('password')->check($password, $user->getPassword())) {
      \Drupal::messenger()->addError(t('Invalid email or password.'));
      return;
    }

    // Kiểm tra nếu user đã bật TFA
    if ($user->get('field_2fa_enabled')->value) {
      // Lưu thông tin user vào session để sử dụng trong bước nhập OTP
      $_SESSION['tfa_user_id'] = $user->id();

      // Chuyển hướng đến form nhập OTP
      $form_state->setRedirect('account_info.2fa_verify');
    } else {
      // Đăng nhập user nếu không dùng TFA
      user_login_finalize($user);
      \Drupal::messenger()->addStatus(t('Login successful!'));
      $form_state->setRedirect('<front>');
    }
  }
}
