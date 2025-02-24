<?php

namespace Drupal\commerce_order\Form;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_order\Entity\OrderInterface;

/**
 * Provides a form for selecting the order's customer (uid and mail fields).
 *
 * Used when adding a new order or reassigning an existing one.
 */
trait CustomerFormTrait {

  /**
   * The user storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $userStorage;

  /**
   * The password generator.
   *
   * @var \Drupal\Core\Password\PasswordGeneratorInterface
   */
  protected $passwordGenerator;

  /**
   * Builds the customer form.
   *
   * @param array $form
   *   The parent form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *   The current order, if known.
   *
   * @return array
   *   The parent form with the customer form elements added.
   */
  public function buildCustomerForm(array $form, FormStateInterface $form_state, ?OrderInterface $order = NULL) {
    $selected_customer_type = $form_state->getValue(['customer_type'], 'existing');
    $wrapper_id = Html::getUniqueId('customer-fieldset-wrapper');

    $form['customer'] = [
      '#type' => 'fieldset',
      '#title' => t('Customer'),
      '#prefix' => '<div id="' . $wrapper_id . '">',
      '#suffix' => '</div>',
    ];
    $form['customer']['customer_type'] = [
      '#type' => 'radios',
      '#title' => t('Order for'),
      '#title_display' => 'invisible',
      '#attributes' => [
        'class' => ['container-inline'],
      ],
      '#required' => TRUE,
      '#options' => [
        'existing' => t('Existing customer'),
        'new' => t('New customer'),
      ],
      '#default_value' => $selected_customer_type,
      '#ajax' => [
        'callback' => [$this, 'customerFormAjax'],
        'wrapper' => $wrapper_id,
      ],
    ];
    if ($selected_customer_type == 'existing') {
      $form['customer']['uid'] = [
        '#type' => 'entity_autocomplete',
        '#title' => t('Search'),
        '#attributes' => [
          'class' => ['container-inline'],
        ],
        '#placeholder' => t('Search by username or email address'),
        '#target_type' => 'user',
        '#required' => TRUE,
        '#selection_handler' => 'commerce:user',
        '#selection_settings' => [
          'match_operator' => 'CONTAINS',
          'include_anonymous' => FALSE,
        ],
      ];
    }
    else {
      // New customer.
      $form['customer']['uid'] = [
        '#type' => 'value',
        '#value' => 0,
      ];
      $form['customer']['mail'] = [
        '#type' => 'email',
        '#title' => t('Email'),
        '#required' => TRUE,
      ];
      $form['customer']['password'] = [
        '#type' => 'container',
      ];
      $form['customer']['password']['generate'] = [
        '#type' => 'checkbox',
        '#title' => t('Generate password'),
        '#default_value' => 1,
      ];
      // The password_confirm element needs to be wrapped in order for #states
      // to work properly. See https://www.drupal.org/node/1427838.
      $form['customer']['password']['password_confirm_wrapper'] = [
        '#type' => 'container',
        '#states' => [
          'visible' => [
            ':input[name="generate"]' => ['checked' => FALSE],
          ],
        ],
      ];
      // We cannot make this required due to HTML5 validation.
      $form['customer']['password']['password_confirm_wrapper']['pass'] = [
        '#type' => 'password_confirm',
        '#size' => 25,
      ];

      $form['customer']['notify'] = [
        '#type' => 'checkbox',
        '#title' => t('Notify user of new account'),
      ];
    }

    return $form;
  }

  /**
   * Ajax callback.
   */
  public function customerFormAjax(array $form, FormStateInterface $form_state) {
    return $form['customer'];
  }

  /**
   * Validation handler for the customer select form.
   *
   * @param array $form
   *   The parent form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateCustomerForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    if (isset($values['mail'], $values['customer_type']) && $values['customer_type'] == 'new') {
      /** @var \Drupal\user\UserInterface $user */
      $user = $this->userStorage->create([
        'name' => $values['mail'],
        'mail' => $values['mail'],
        'pass' => ($values['generate']) ? $this->passwordGenerator->generate() : $values['pass'],
        'status' => TRUE,
      ]);
      $form_state->set('customer', $user);
      $violations = $user->validate();

      foreach ($violations->getByFields(['mail']) as $violation) {
        $form_state->setErrorByName(str_replace('.', '][', $violation->getPropertyPath()), $violation->getMessage());
      }
    }
  }

  /**
   * Submit handler for the customer select form.
   *
   * @param array $form
   *   An associative array containing the structure of the parent form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitCustomerForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    if ($values['customer_type'] == 'existing') {
      $values['mail'] = $this->userStorage->load($values['uid'])->getEmail();
    }
    else {
      $user = $form_state->get('customer');
      $user->save();
      $values['uid'] = $user->id();

      if ($values['notify']) {
        _user_mail_notify('register_admin_created', $user);
      }
    }

    $form_state->setValues($values);
  }

}
