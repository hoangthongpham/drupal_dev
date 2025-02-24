<?php

namespace Drupal\commerce_promotion\Plugin\Commerce\PromotionOffer;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\commerce_promotion\Entity\PromotionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the base class for offers.
 */
abstract class PromotionOfferBase extends PluginBase implements PromotionOfferInterface, ContainerFactoryPluginInterface {

  /**
   * The rounder.
   *
   * @var \Drupal\commerce_price\RounderInterface
   */
  protected $rounder;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->setConfiguration($configuration);
    $instance->rounder = $container->get('commerce_price.rounder');

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {
    $this->configuration = NestedArray::mergeDeep($this->defaultConfiguration(), $configuration);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    // Wrap the offer configuration in a fieldset by default.
    $form['#type'] = 'fieldset';
    $form['#title'] = $this->t('Offer');
    $form['#collapsible'] = FALSE;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    if (!$form_state->getErrors()) {
      $this->configuration = [];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityTypeId() {
    return $this->pluginDefinition['entity_type'];
  }

  /**
   * {@inheritdoc}
   */
  public function clear(EntityInterface $entity, PromotionInterface $promotion) {}

  /**
   * Asserts that the given entity is of the expected type.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity.
   */
  protected function assertEntity(EntityInterface $entity) {
    $entity_type_id = $entity->getEntityTypeId();
    $offer_entity_type_id = $this->getEntityTypeId();
    if ($entity_type_id != $offer_entity_type_id) {
      throw new \InvalidArgumentException(sprintf('The offer requires a "%s" entity, but a "%s" entity was given.', $offer_entity_type_id, $entity_type_id));
    }
  }

}
