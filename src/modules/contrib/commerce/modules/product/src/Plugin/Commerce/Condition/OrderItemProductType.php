<?php

namespace Drupal\commerce_product\Plugin\Commerce\Condition;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\commerce\Attribute\CommerceCondition;
use Drupal\commerce\Plugin\Commerce\Condition\ConditionBase;
use Drupal\commerce_product\Entity\ProductVariationInterface;

/**
 * Provides the product type condition for order items.
 */
#[CommerceCondition(
  id: "order_item_product_type",
  label: new TranslatableMarkup("Product type"),
  entity_type: "commerce_order_item",
  display_label: new TranslatableMarkup("Product types"),
  category: new TranslatableMarkup("Products"),
)]
class OrderItemProductType extends ConditionBase {

  use ProductTypeTrait;

  /**
   * {@inheritdoc}
   */
  public function evaluate(EntityInterface $entity) {
    $this->assertEntity($entity);
    /** @var \Drupal\commerce_order\Entity\OrderItemInterface $order_item */
    $order_item = $entity;
    /** @var \Drupal\commerce_product\Entity\ProductVariationInterface $purchased_entity */
    $purchased_entity = $order_item->getPurchasedEntity();
    if (!$purchased_entity instanceof ProductVariationInterface ||
      !$purchased_entity->getProduct()) {
      return FALSE;
    }
    $product_type = $purchased_entity->getProduct()->bundle();

    return in_array($product_type, $this->configuration['product_types']);
  }

}
