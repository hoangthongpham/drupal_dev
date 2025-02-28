<?php
namespace Drupal\homepage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;

/**
 * Custom login page controller.
 */
class LoginController extends ControllerBase {

  /**
   * Displays the login form.
   */
  public function loginPage() {
    return [
      '#theme' => 'custom_login_page',
      '#login_form' => \Drupal::formBuilder()->getForm('Drupal\homepage\Form\CustomLoginForm'),
      '#register_link' => Url::fromRoute('user.register')->toString(),
    ];
  }

}
