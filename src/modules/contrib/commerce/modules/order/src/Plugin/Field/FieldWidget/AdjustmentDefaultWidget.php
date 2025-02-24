<?php

namespace Drupal\commerce_order\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\commerce_order\Adjustment;
use Drupal\commerce_price\Price;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of 'commerce_adjustment_default'.
 */
#[FieldWidget(
  id: "commerce_adjustment_default",
  label: new TranslatableMarkup("Adjustment"),
  field_types: ["commerce_adjustment"],
)]
class AdjustmentDefaultWidget extends WidgetBase {

  /**
   * The adjustment type manager.
   *
   * @var \Drupal\commerce_order\AdjustmentTypeManager
   */
  protected $adjustmentTypeManager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->adjustmentTypeManager = $container->get('plugin.manager.commerce_adjustment_type');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\commerce_order\Adjustment $adjustment */
    $adjustment = $items[$delta]->value;

    $element['#type'] = 'container';
    $element['#attributes']['class'][] = 'form--inline';
    $element['#attached']['library'][] = 'commerce_price/admin';

    $types = [
      '_none' => $this->t('- Select -'),
    ];
    foreach ($this->adjustmentTypeManager->getDefinitions() as $id => $definition) {
      if (!empty($definition['has_ui'])) {
        $types[$id] = $definition['label'];
      }
    }

    $element['type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#options' => $types,
      '#weight' => 1,
      '#default_value' => ($adjustment) ? $adjustment->getType() : '_none',
    ];

    // If this is being added through the UI, the source ID should be empty,
    // and we will want to default it to custom.
    $source_id = ($adjustment) ? $adjustment->getSourceId() : NULL;
    $element['source_id'] = [
      '#type' => 'value',
      '#value' => empty($source_id) ? 'custom' : $source_id,
    ];
    // If this is being added through the UI, the adjustment should be locked.
    // UI added adjustments need to be locked to persist after an order refresh.
    $element['locked'] = [
      '#type' => 'value',
      '#value' => ($adjustment) ? $adjustment->isLocked() : TRUE,
    ];

    $states_selector_name = $this->fieldDefinition->getName() . "[$delta][type]";
    $element['definition'] = [
      '#type' => 'container',
      '#weight' => 2,
      '#states' => [
        'invisible' => [
          'select[name="' . $states_selector_name . '"]' => ['value' => '_none'],
        ],
      ],
    ];
    $element['definition']['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#size' => 20,
      '#default_value' => ($adjustment) ? $adjustment->getLabel() : '',
    ];
    $element['definition']['amount'] = [
      '#type' => 'commerce_price',
      '#title' => $this->t('Amount'),
      '#default_value' => ($adjustment) ? $adjustment->getAmount()->toArray() : NULL,
      '#allow_negative' => TRUE,
      '#states' => [
        'optional' => [
          'select[name="' . $states_selector_name . '"]' => ['value' => '_none'],
        ],
      ],
      '#attributes' => ['class' => ['clearfix']],
    ];
    $element['definition']['included'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Included in the base price'),
      '#default_value' => $adjustment && $adjustment->isIncluded(),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as $key => $value) {
      if ($value['type'] == '_none') {
        continue;
      }
      // The method can be called with invalid or incomplete data, in
      // preparation for validation. Passing such data to the Adjustment
      // object would result in an exception.
      if (empty($value['definition']['label'])) {
        $form_state->setErrorByName('adjustments[' . $key . '][definition][label]', $this->t('The adjustment label field is required.'));
        continue;
      }

      $values[$key] = new Adjustment([
        'type' => $value['type'],
        'label' => $value['definition']['label'],
        'amount' => new Price($value['definition']['amount']['number'], $value['definition']['amount']['currency_code']),
        'source_id' => $value['source_id'],
        'included' => $value['definition']['included'],
        'locked' => $value['locked'],
      ]);
    }
    return $values;
  }

}
