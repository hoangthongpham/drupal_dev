<?php

namespace Drupal\commerce_promotion\Plugin\Commerce\PromotionOffer;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\commerce_order\Adjustment;
use Drupal\commerce_promotion\Attribute\CommercePromotionOffer;
use Drupal\commerce_promotion\Entity\PromotionInterface;

/**
 * Provides the percentage off offer for order items.
 */
#[CommercePromotionOffer(
  id: "order_item_fixed_amount_off",
  label: new TranslatableMarkup("Fixed amount off each matching product"),
  entity_type: "commerce_order_item"
)]
class OrderItemFixedAmountOff extends OrderItemPromotionOfferBase {

  use FixedAmountOffTrait;

  /**
   * {@inheritdoc}
   */
  public function apply(EntityInterface $entity, PromotionInterface $promotion) {
    $this->assertEntity($entity);
    /** @var \Drupal\commerce_order\Entity\OrderItemInterface $order_item */
    $order_item = $entity;
    $adjusted_total_price = $order_item->getAdjustedTotalPrice(['promotion']);
    $amount = $this->getAmount();
    if ($adjusted_total_price->getCurrencyCode() != $amount->getCurrencyCode()) {
      return;
    }
    if ($this->configuration['display_inclusive']) {
      // First, get the adjusted unit price to ensure the order item is not
      // already fully discounted.
      $adjusted_unit_price = $order_item->getAdjustedUnitPrice(['promotion']);

      // The adjusted unit price is already reduced to 0, no need to continue
      // further.
      if ($adjusted_unit_price->isZero()) {
        return;
      }
      // Display-inclusive promotions must first be applied to the unit price.
      if ($amount->greaterThan($adjusted_unit_price)) {
        // Don't reduce the unit price past zero.
        $amount = $adjusted_unit_price;
      }
      $unit_price = $order_item->getUnitPrice();
      $new_unit_price = $unit_price->subtract($amount);
      $order_item->setUnitPrice($new_unit_price);
      $adjustment_amount = $amount->multiply($order_item->getQuantity());
      $adjustment_amount = $this->rounder->round($adjustment_amount);
    }
    else {
      $adjustment_amount = $amount->multiply($order_item->getQuantity());
      $adjustment_amount = $this->rounder->round($adjustment_amount);
      if ($adjustment_amount->greaterThan($adjusted_total_price)) {
        // Don't reduce the order item total price past zero.
        $adjustment_amount = $adjusted_total_price;
      }
    }

    // Skip applying the promotion if there's no amount to discount.
    if ($adjustment_amount->isZero()) {
      return;
    }

    $order_item->addAdjustment(new Adjustment([
      'type' => 'promotion',
      'label' => $promotion->getDisplayName() ?: $this->t('Discount'),
      'amount' => $adjustment_amount->multiply('-1'),
      'source_id' => $promotion->id(),
      'included' => $this->configuration['display_inclusive'],
    ]));
  }

}
