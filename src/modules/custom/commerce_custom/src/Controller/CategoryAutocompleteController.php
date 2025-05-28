<?php

namespace Drupal\commerce_custom\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\taxonomy\Entity\Term;

class CategoryAutocompleteController extends ControllerBase
{

  public function handle(Request $request)
  {
    $results = [];
    $input = $request->query->get('q');

    if (str_starts_with($input, 'id=')) {
      $categoryId = str_replace('id=', '', $input);
      $terms = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->loadByProperties([
          'field_category_id' => $categoryId,
          'vid' => 'category',
        ]);

      foreach ($terms as $term) {
        $label = $term->label();
        $value = "$label ($categoryId)";
        $results[] = ['value' => $value, 'label' => $label];
      }
    } else {
      // Optional fallback by name
      $query = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->getQuery()
        ->condition('name', $input, 'CONTAINS')
        ->condition('vid', 'category')
        ->range(0, 10)
        ->execute();

      $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadMultiple($query);
      foreach ($terms as $term) {
        $categoryId = $term->get('field_category_id')->value;
        $label = $term->label();
        $value = "$label ($categoryId)";
        $results[] = ['value' => $value, 'label' => $label];
      }
    }

    return new JsonResponse($results);
  }
}
