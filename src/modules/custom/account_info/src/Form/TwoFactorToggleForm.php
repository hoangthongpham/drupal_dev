<?php

namespace Drupal\account_info\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TwoFactorToggleForm extends FormBase
{

  protected $currentUser;

  public function __construct(AccountProxyInterface $current_user)
  {
    $this->currentUser = $current_user;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('current_user')
    );
  }

  public function getFormId()
  {
    return 'account_info_2fa_toggle_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $user = User::load($this->currentUser->id());
    $tfa_enabled = $user->get('field_2fa_enabled')->value ?? FALSE;

    $form['toggle_2fa'] = [
      '#type' => 'submit',
      '#value' => $tfa_enabled ? 'Disable 2FA' : 'Enable 2FA',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $user = User::load($this->currentUser->id());
    $tfa_enabled = $user->get('field_2fa_enabled')->value ?? FALSE;
    $user->set('field_2fa_enabled', !$tfa_enabled);
    $user->save();

    \Drupal::messenger()->addMessage($tfa_enabled ? '2FA Disabled' : '2FA Enabled');
  }
}
