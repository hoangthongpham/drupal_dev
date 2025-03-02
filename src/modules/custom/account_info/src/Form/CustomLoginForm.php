<?php

namespace Drupal\account_info\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Session\SessionManagerInterface;

class CustomLoginForm extends FormBase
{

  protected $currentUser;
  protected $messenger;
  protected $sessionManager;

  public function __construct(AccountProxyInterface $current_user, MessengerInterface $messenger, SessionManagerInterface $session_manager)
  {
    $this->currentUser = $current_user;
    $this->messenger = $messenger;
    $this->sessionManager = $session_manager;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('current_user'),
      $container->get('messenger'),
      $container->get('session_manager')
    );
  }

  public function getFormId()
  {
    return 'account_info_custom_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Email',
      '#required' => TRUE,
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => 'Password',
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Login',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $email = $form_state->getValue('email');
    $password = $form_state->getValue('password');

    $users = \Drupal::entityTypeManager()->getStorage('user')->loadByProperties(['mail' => $email]);
    $user = reset($users);

    if ($user && \Drupal::service('password')->check($password, $user->getPassword())) {
      if ($user->get('field_2fa_enabled')->value) {
        // Lưu user ID vào session để xác thực OTP
        \Drupal::request()->getSession()->set('2fa_user_id', $user->id());
        $form_state->setRedirect('account_info.2fa_verify');
      } else {
        user_login_finalize($user);
        $this->messenger->addMessage('Login successful.');
        $form_state->setRedirect('<front>');
      }
    } else {
      $this->messenger->addError('Invalid email or password.');
    }
  }
}
