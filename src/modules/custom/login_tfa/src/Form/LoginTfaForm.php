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
    // Get current step from form state
    $step = $form_state->get('step') ?: 1;

    $form['#prefix'] = '<div id="otp-form-wrapper">';
    $form['#suffix'] = '</div>';
    $form['#attributes']['class'] = ['container', 'p-4', 'mb-4', 'shadow', 'rounded', 'bg-light'];
    if ($step == 1) {
      // step 1: Input Username and Password
      $form['name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Username'),
      ];

      $form['pass'] = [
        '#type' => 'password',
        '#title' => $this->t('Password'),
      ];

      $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Tiếp tục'),
      ];
    } elseif ($step == 2) {
      // step 2: Input code TFA
      $form['tfa_code'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Code TFA'),
        '#required' => TRUE,
        '#description' => $this->t('Enter the code sent to your email or from the TFA app.'),
      ];

      $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Verify'),
      ];
    }

    $form['#step'] = $step;
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $step = $form_state->get('step') ?: 1;

    if ($step == 1) {
      // Verify username and password
      $username = $form_state->getValue('name');
      $password = $form_state->getValue('pass');

      $account = user_load_by_name($username);
      if (!$account || !\Drupal::service('user.auth')->authenticate($username, $password)) { 
        $form_state->setErrorByName('name', $this->t('Incorrect username or password.'));
      } else {
        // Save temporary account information
        $form_state->set('account', $account);
        // Simulate sending TFA code (can integrate email or Google Authenticator)
        $tfa_code = random_int(100000, 999999); // Generate random code as an example
        $form_state->set('tfa_code', $tfa_code);
        \Drupal::messenger()->addMessage($this->t('Your TFA code is: @code (This is an example, in reality the code will be sent via email).', ['@code' => $tfa_code]));
      }
    } elseif ($step == 2) {
      // TFA Code Authentication
      $input_code = $form_state->getValue('tfa_code');
      $stored_code = $form_state->get('tfa_code');

      if ($input_code != $stored_code) {
        $form_state->setErrorByName('tfa_code', $this->t('TFA code is incorrect.'));
      }
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $step = $form_state->get('step') ?: 1;

    if ($step == 1) {
      // Go to step 2
      $form_state->set('step', 2);
      $form_state->setRebuild(TRUE);
    } elseif ($step == 2) {
      // Login successful
      $account = $form_state->get('account');
      user_login_finalize($account);
      $form_state->setRedirect('<front>');
      \Drupal::messenger()->addMessage($this->t('Login successful!'));
    }
  }
}
