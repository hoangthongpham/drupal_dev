<?php

namespace Drupal\account_info\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Render\Markup;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccountInfoController extends ControllerBase
{

  protected $currentUser;
  protected $formBuilder;

  public function __construct(AccountProxyInterface $current_user, FormBuilderInterface $form_builder)
  {
    $this->currentUser = $current_user;
    $this->formBuilder = $form_builder;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('current_user'),
      $container->get('form_builder')
    );
  }

  /**
   * Redirect to custom login if user is not logged in.
   */
  public function checkUserLogin()
  {
    if ($this->currentUser->isAnonymous()) {
      return new RedirectResponse(Url::fromRoute('account_info.custom_login')->toString());
    }
    return NULL;
  }

  /**
   * Displays user account info and 2FA status.
   */
  public function userInfo()
  {
    if ($redirect = $this->checkUserLogin()) {
      return $redirect;
    }

    $user = User::load($this->currentUser->id());
    $tfa_enabled = $user->get('field_2fa_enabled')->value ?? FALSE;

    $status = [
      '#markup' => 'Two-Factor Authentication Status: <strong style="color: ' . ($tfa_enabled ? 'green' : 'red') . ';">' .
        ($tfa_enabled ? 'Enabled' : 'Disabled') .
        '</strong>',
      '#allowed_tags' => ['strong'],
    ];
    $toggle_form = $this->formBuilder->getForm('Drupal\account_info\Form\TwoFactorToggleForm');

    return [
      '#theme' => 'two_column_layout',
      '#left_sidebar' => $this->getSidebar(),
      '#content' => [
        [
          '#markup' => Markup::create("<h2>User Information</h2>"),
        ],
        [
          '#theme' => 'item_list',
          '#items' => [
            'Username: ' . $user->getAccountName(),
            'Email: ' . $user->getEmail(),
            'Roles: ' . implode(', ', $user->getRoles()),
            'Created: ' . \Drupal::service('date.formatter')->format($user->getCreatedTime(), 'custom', 'd/m/Y H:i'),
            $status,
          ],
        ],
        $toggle_form,
      ],
    ];
  }

  /**
   * Sidebar menu for account settings.
   */
  private function getSidebar()
  {
    return [
      '#theme' => 'item_list',
      '#items' => [
        ['#markup' => '<a href="/account-info">Account Information</a>'],
        ['#markup' => '<a href="/account-info/2fa">Two-Factor Authentication</a>'],
        ['#markup' => '<a href="/user/logout">Logout</a>'],
      ],
    ];
  }

  /**
   * Toggles the 2FA setting for the current user.
   */
  public function toggleTwoFactor()
  {
    if ($redirect = $this->checkUserLogin()) {
      return $redirect;
    }

    $user = User::load($this->currentUser->id());
    $tfa_enabled = $user->get('field_2fa_enabled')->value ?? FALSE;
    $user->set('field_2fa_enabled', !$tfa_enabled);
    $user->save();

    \Drupal::messenger()->addMessage($tfa_enabled ? 'Two-Factor Authentication Disabled' : 'Two-Factor Authentication Enabled');

    return new RedirectResponse(Url::fromRoute('account_info.user_info')->toString());
  }

  public function twoFactorSettings()
  {
    $user = User::load($this->currentUser->id());
    $tfa_enabled = $user->get('field_2fa_enabled')->value ?? FALSE;

    $form = $this->formBuilder->getForm('Drupal\account_info\Form\TwoFactorToggleForm');

    return [
      '#theme' => 'item_list',
      '#items' => [
        'Two-Factor Authentication: ' . ($tfa_enabled ? 'Enabled' : 'Disabled'),
        $form,
      ],
      '#title' => 'Two-Factor Authentication Settings',
    ];
  }
}
