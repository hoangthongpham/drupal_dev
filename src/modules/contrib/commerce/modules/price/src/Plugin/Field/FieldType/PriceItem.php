<?php

namespace Drupal\commerce_price\Plugin\Field\FieldType;

use Drupal\commerce_price\Price;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'commerce_price' field type.
 *
 * @FieldType(
 *   id = "commerce_price",
 *   label = @Translation("Price"),
 *   description = @Translation("Stores a decimal number and a three letter currency code."),
 *   category = "commerce",
 *   default_widget = "commerce_price_default",
 *   default_formatter = "commerce_price_default",
 * )
 */
class PriceItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['number'] = DataDefinition::create('string')
      ->setLabel(t('Number'))
      ->setRequired(FALSE);

    $properties['currency_code'] = DataDefinition::create('string')
      ->setLabel(t('Currency code'))
      ->setRequired(FALSE);

    $properties['formatted'] = DataDefinition::create('formatted_price')
      ->setLabel(t('Formatted price'))
      ->setComputed(TRUE)
      ->setInternal(FALSE)
      ->setRequired(FALSE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'number' => [
          'description' => 'The number.',
          'type' => 'numeric',
          'precision' => 19,
          'scale' => 6,
        ],
        'currency_code' => [
          'description' => 'The currency code.',
          'type' => 'varchar',
          'length' => 3,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $available_currencies = array_filter($field_definition->getSetting('available_currencies'));
    if (count($available_currencies) === 0) {
      /** @var \Drupal\commerce_price\Entity\CurrencyInterface[] $currencies */
      $currencies = \Drupal::entityTypeManager()->getStorage('commerce_currency')->loadMultiple();
      $sample_currency_code = reset($currencies)->getCurrencyCode();
    }
    else {
      $sample_currency_code = reset($available_currencies);
    }

    return [
      'number' => '9.99',
      'currency_code' => $sample_currency_code,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return [
      'available_currencies' => [],
      'allow_negative' => FALSE,
    ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $currencies = \Drupal::entityTypeManager()->getStorage('commerce_currency')->loadMultiple();
    $currency_codes = array_keys($currencies);

    $element = [];
    $element['available_currencies'] = [
      '#type' => count($currency_codes) < 10 ? 'checkboxes' : 'select',
      '#title' => $this->t('Available currencies'),
      '#description' => $this->t('If no currencies are selected, all currencies will be available.'),
      '#options' => array_combine($currency_codes, $currency_codes),
      '#default_value' => $this->getSetting('available_currencies'),
      '#multiple' => TRUE,
      '#size' => 5,
    ];

    $element['allow_negative'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow negative prices'),
      '#default_value' => $this->getSetting('allow_negative'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function fieldSettingsToConfigData(array $settings) {
    $settings['available_currencies'] = array_filter(
      $settings['available_currencies']
    );
    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraint_manager = $this->getTypedDataManager()->getValidationConstraintManager();
    $constraints = parent::getConstraints();
    $constraints[] = $constraint_manager->create('ComplexData', [
      'number' => [
        'Regex' => [
          'pattern' => '/^[+-]?((\d+(\.\d*)?)|(\.\d+))$/i',
        ],
      ],
    ]);
    $available_currencies = array_filter($this->getSetting('available_currencies'));
    $constraints[] = $constraint_manager->create('Currency', ['availableCurrencies' => $available_currencies]);

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return $this->number === NULL || $this->number === '' || empty($this->currency_code);
  }

  /**
   * {@inheritdoc}
   */
  public function setValue($values, $notify = TRUE) {
    // Allow callers to pass a Price value object as the field item value.
    if ($values instanceof Price) {
      $price = $values;
      $values = [
        'number' => $price->getNumber(),
        'currency_code' => $price->getCurrencyCode(),
      ];
    }
    parent::setValue($values, $notify);
  }

  /**
   * Gets the Price value object for the current field item.
   *
   * @return \Drupal\commerce_price\Price
   *   The Price value object.
   */
  public function toPrice() {
    return new Price($this->number, $this->currency_code);
  }

}
