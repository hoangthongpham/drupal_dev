<?php

namespace Drupal\recipe_module\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\node\Entity\Node;

/**
 * Provides a REST resource for recipes.
 *
 * @RestResource(
 *   id = "recipe_resource",
 *   label = @Translation("Recipe Resource"),
 *   uri_paths = {
 *     "canonical" = "/api/recipes"
 *   }
 * )
 */
class RecipeResource extends ResourceBase {

  public function get() {
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'recipe')
      ->sort('created', 'DESC');
    $nids = $query->execute();

    $nodes = Node::loadMultiple($nids);

    $recipes = [];
    foreach ($nodes as $node) {
      $recipes[] = [
        'id' => $node->id(),
        'title' => $node->getTitle(),
        'body' => $node->get('body')->value,
      ];
    }

    return new ResourceResponse($recipes);
  }
}