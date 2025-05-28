<?php

namespace Drupal\commerce_custom\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for providing autocomplete suggestions.
 */
class AutocompleteController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new AutocompleteController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Handler for autocomplete request for custom category IDs.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   * The request object.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   * A JSON response containing the autocomplete suggestions.
   */
  public function handleCustomCategoryId(Request $request) {
    $matches = [];
    $input = $request->query->get('q');
    $vocabulary_id = 'category';
    $field_name_on_term = 'field_category_id';

    if (strlen($input) >= 1) {
      $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
        ->condition('vid', $vocabulary_id)
        ->condition($field_name_on_term, $input)
        ->accessCheck()
        ->range(0, 10);

      $tids = $query->execute();

      if (!empty($tids)) {
        $terms = $this->entityTypeManager->getStorage('taxonomy_term')
          ->loadMultiple($tids);
        $found_values = [];
        foreach ($terms as $term) {
          if ($term->hasField($field_name_on_term) && !$term->get($field_name_on_term)
              ->isEmpty()) {
            $field_value = $term->get($field_name_on_term)->value;

            if (!in_array($field_value, $found_values)) {
              $matches[] = [
                'value' => $field_value . ' (' . $term->getName() . ')',
                'label' => $field_value . ' (' . $term->getName() . ')',
              ];
              $found_values[] = $field_value;
            }
          }
        }
      }
    }
    return new JsonResponse($matches);
  }

}