<?php
namespace Drupal\homepage\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\user\UserAuthInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Custom login form.
 */
class CustomLoginForm extends FormBase {

  /**
   * User authentication service.
   *
   * @var \Drupal\user\UserAuthInterface
   */
  protected $userAuth;

  /**
   * Current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructor.
   */
  public function __construct(UserAuthInterface $userAuth, AccountProxyInterface $currentUser, MessengerInterface $messenger) {
    $this->userAuth = $userAuth;
    $this->currentUser = $currentUser;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.auth'),
      $container->get('current_user'),
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mymodule_custom_login_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['mail'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username or Email'),
      '#required' => TRUE,
    ];

      $form['otp_example'] = [
          '#type' => 'otp_field',
          '#title' => 'OTP Field Example',
          '#required' => TRUE,
          '#otp_field_processor' => 'otp_field_sms_processor',
      ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Log in'),
      '#button_type' => 'primary',
    ];

    $form['links'] = [
      '#markup' => '<p><a href="' . Url::fromRoute('user.pass')->toString() . '">' . $this->t('Forgot password?') . '</a></p>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $mail = $form_state->getValue('mail');
    $password = $form_state->getValue('pass');
    $username = homepage_find_username_by_email($mail);
    $uid = $this->userAuth->authenticate($username, $password);
    if ($uid) {
      user_login_finalize(\Drupal\user\Entity\User::load($uid));
      $this->messenger->addMessage($this->t('Login successful.'));
      $form_state->setRedirect('<front>');
    } else {
      $this->messenger->addError($this->t('Invalid username or password.'));
    }
  }
}
