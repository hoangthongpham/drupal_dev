<?php

namespace Drupal\commerce_custom\Plugin\Commerce\PromotionOffer;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\commerce_price\Price;
use Drupal\commerce_promotion\Entity\PromotionInterface;
use Drupal\commerce_promotion\Plugin\Commerce\PromotionOffer\OrderItemPromotionOfferBase; // Hoặc OrderPromotionOfferBase
use Drupal\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a custom offer with internal conditional logic.
 *
 * Ví dụ: "Giảm X tiền cho mỗi sản phẩm Y nếu sản phẩm đó có trường Z = A"
 *
 * @CommercePromotionOffer(
 * id = "my_custom_conditional_offer",
 * label = @Translation("Conditional Offer for categories"),
 * entity_type = "commerce_order_item",
 * )
 */
class MyCustomConditionalOffer extends OrderItemPromotionOfferBase { // Hoặc OrderPromotionOfferBase
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
        'discount_amount' => '0', // Số tiền giảm giá (chỉ là ví dụ)
        'target_codes' => [],     // Danh sách các code tùy chỉnh để "Apply to"
        'target_field_name' => 'field_custom_target_code', // Trường trên Product để kiểm tra
        'target_field_property' => 'value', // Thuộc tính của trường để lấy giá trị
      ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    //$form = parent::buildConfigurationForm($form, $form_state); // Có thể gọi hoặc không, tùy bạn muốn kế thừa gì

    // Xóa các trường "conditions" mặc định nếu có từ OrderItemPromotionOfferBase
    // mà bạn không muốn sử dụng.
     unset($form['conditions']); // Ví dụ

    // === TRƯỜNG CẤU HÌNH CHO OFFER (VÍ DỤ: SỐ TIỀN GIẢM GIÁ) ===
    $form['discount_amount'] = [
      '#type' => 'commerce_price',
      '#title' => $this->t('Discount Amount'),
      '#default_value' => ['number' => $this->configuration['discount_amount'], 'currency_code' => 'VND'], // Thay 'VND' bằng currency mặc định của bạn
      '#required' => TRUE,
    ];

    // === CÁC TRƯỜNG CẤU HÌNH CHO LOGIC "APPLY TO" TÙY CHỈNH ===
    $form['apply_to_settings_title'] = [
      '#type' => 'html_tag',
      '#tag' => 'h4',
      '#value' => $this->t('Apply To'),
    ];

    // Xây dựng #default_value cho target_codes_input với định dạng mong muốn
    $target_codes_display_string = '';
    $saved_ids = $this->configuration['target_codes'] ?? [];

    if (!empty($saved_ids) && is_array($saved_ids)) {
      $display_values = [];
      $term_storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');

      // GIẢ ĐỊNH: Các thông tin này phải khớp với AutocompleteController của bạn
      $field_on_term_for_id = 'field_category_id'; // Tên trường trên TERM chứa custom ID
      $vocabulary_id = 'category';            // Vocabulary của term

      foreach ($saved_ids as $id) {
        if (empty($id)) continue; // Bỏ qua ID rỗng

        $terms = $term_storage->loadByProperties([
          'vid' => $vocabulary_id,
          $field_on_term_for_id => $id,
        ]);

        if (!empty($terms)) {
          $term = reset($terms); // Lấy term đầu tiên tìm thấy
          $display_values[] = $id . ' (' . $term->getName() . ')';
        } else {
          // Nếu không tìm thấy term (có thể đã bị xóa), chỉ hiển thị ID
          $display_values[] = $id . ' (' . $this->t('Term not found') . ')';
        }
      }
      $target_codes_display_string = implode(', ', $display_values);
    }

    $form['target_codes_input'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Target Category IDs (from Taxonomy)'),
      '#description' => $this->t('Start typing the custom category ID. Separate multiple entries with a comma. Format: ID (Term Name).'),
      '#default_value' => $target_codes_display_string, // Sử dụng chuỗi đã định dạng
      '#autocomplete_route_name' => 'mymodule.autocomplete.custom_category_id',
      // '#attributes' => ['class' => ['tags']], // Nếu theme admin của bạn hỗ trợ input tags
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::validateConfigurationForm($form, $form_state);
    $values = $form_state->getValue($form['#parents']);

    // Kiểm tra discount_amount
    if (empty($values['discount_amount']['number']) || !is_numeric($values['discount_amount']['number']) || $values['discount_amount']['number'] < 0) {
      $form_state->setErrorByName('discount_amount', $this->t('Please enter a valid positive discount amount.'));
    }

    // Nếu required_field_name được nhập, thì required_field_value cũng nên được nhập
    if (!empty($values['required_field_name']) && empty($values['required_field_value'])) {
      $form_state->setErrorByName('required_field_value', $this->t('If a required field name is specified, its value must also be specified.'));
    }
    if (empty($values['field_property']) && !empty($values['required_field_name'])) {
      $form_state->setErrorByName('field_property', $this->t('Field property must be specified if a field name is provided.'));
    }
  }


  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    $this->configuration['discount_amount'] = $values['discount_amount']['number'] ?? '0';
    $this->configuration['target_field_name'] = isset($values['target_field_name']) ? trim($values['target_field_name']) : '';
    $this->configuration['target_field_property'] = isset($values['target_field_property']) ? trim($values['target_field_property']) : 'value';

    $cleaned_ids = [];
    if (isset($values['target_codes_input']) && !empty($values['target_codes_input'])) {
      $raw_parts = explode(',', $values['target_codes_input']);

      foreach ($raw_parts as $part) {
        $trimmed_part = trim($part);
        // Cố gắng trích xuất ID từ định dạng "ID (Tên Term)"
        // Regex này lấy phần trước dấu ngoặc đơn đầu tiên.
        if (preg_match('/^([^(]+)\s*\(.*\)$/', $trimmed_part, $id_match)) {
          $cleaned_ids[] = trim($id_match[1]);
        }
        // Nếu không khớp regex (ví dụ: người dùng chỉ nhập ID), vẫn lấy giá trị đó
        elseif (!empty($trimmed_part)) {
          $cleaned_ids[] = $trimmed_part;
        }
      }
    }
    // Lọc bỏ các giá trị rỗng và trùng lặp
    $this->configuration['target_codes'] = array_values(array_unique(array_filter($cleaned_ids, function($value) {
      return $value !== '' && $value !== NULL;
    })));
  }

  /**
   * {@inheritdoc}
   *
   * Áp dụng ưu đãi cho order item nếu nó đáp ứng các điều kiện nội bộ.
   */
  public function apply(EntityInterface $entity, PromotionInterface $promotion) {
    /** @var \Drupal\commerce_order\Entity\OrderItemInterface $order_item */
    $order_item = $entity; // Vì entity_type là 'commerce_order_item'
    $order = $order_item->getOrder();
    if (!$order) {
      return; // Không thể áp dụng nếu không có đơn hàng
    }

    // Lấy cấu hình
    $discount_amount_number = $this->configuration['discount_amount'];
    $required_field_name = $this->configuration['required_field_name'];
    $required_field_value = $this->configuration['required_field_value'];
    $field_property = $this->configuration['field_property'] ?: 'value'; // Mặc định là 'value'

    // Nếu không có số tiền giảm giá hoặc không có điều kiện trường tùy chỉnh nào được đặt, không làm gì cả
    if (empty($discount_amount_number) || empty($required_field_name)) {
      return;
    }

    $purchased_entity = $order_item->getPurchasedEntity();
    if (!$purchased_entity || !$purchased_entity->hasmethod('getProduct')) {
      return;
    }
    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $product = $purchased_entity->getProduct();
    if (!$product) {
      return;
    }

    // *** LOGIC ĐIỀU KIỆN NỘI BỘ CỦA OFFER ***
    $condition_met = FALSE;
    if ($product->hasField($required_field_name) && !$product->get($required_field_name)->isEmpty()) {
      $field_items = $product->get($required_field_name);
      foreach ($field_items as $field_item) {
        if (property_exists($field_item, $field_property)) {
          $actual_value = $field_item->{$field_property};
          if ((string)$actual_value === (string)$required_field_value) {
            $condition_met = TRUE;
            break; // Tìm thấy giá trị khớp, không cần kiểm tra thêm
          }
        }
      }
    }

    if ($condition_met) {
      // Điều kiện nội bộ được đáp ứng, tiến hành tạo adjustment
      $discount_price = new Price((string) $discount_amount_number, $order->getTotalPrice()->getCurrencyCode());

      // Giảm giá trên mỗi đơn vị của order item, sau đó nhân với số lượng
      // Hoặc bạn có thể muốn giảm giá tổng cộng cho order item này bất kể số lượng
      // Ví dụ: giảm giá trên tổng của order item
      $total_item_price = $order_item->getTotalPrice();
      if ($discount_price->greaterThan($total_item_price)) {
        // Đảm bảo giảm giá không lớn hơn giá của item
        $discount_price = $total_item_price;
      }
      // Chỉ áp dụng nếu discount_price > 0
      if ($discount_price->isPositive()) {
        $order_item->addAdjustment($this->createAdjustment($promotion, $discount_price, TRUE));
      }
    }
  }

  /**
   * Tạo một đối tượng adjustment.
   * Helper function.
   */
  protected function createAdjustment(PromotionInterface $promotion, Price $amount, $included_in_price = FALSE) {
    return new \Drupal\commerce_order\Adjustment([
      'type' => 'promotion',
      'label' => $promotion->getDisplayName() ?: $this->t('Discount'), // Lấy tên hiển thị của promotion
      'amount' => $amount->multiply('-1'), // Giảm giá nên là số âm
      'source_id' => $promotion->id(),
      'included_in_price' => $included_in_price, // Quan trọng nếu giá đã bao gồm thuế
    ]);
  }
}