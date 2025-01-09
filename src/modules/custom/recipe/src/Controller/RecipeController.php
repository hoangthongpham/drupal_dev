<?php

declare(strict_types=1);

namespace Drupal\recipe\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Returns responses for recipe routes.
 */
final class RecipeController extends ControllerBase
{

  /**
   * Builds the response.
   */
  public function list() {
    // Lấy danh sách bài viết loại "recipe".
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'recipe')
      ->accessCheck(FALSE)
      ->sort('created', 'DESC');
    $nids = $query->execute();
  
    $nodes = Node::loadMultiple($nids);
  
    // Tạo danh sách bài viết với class Bootstrap.
    $recipes = [];
    foreach ($nodes as $node) {
      $recipes[] = [
        'title' => $node->getTitle(),
        'body' => $node->get('body')->value,
        'edit_url' => \Drupal\Core\Url::fromRoute('recipe.edit', ['nid' => $node->id()]),
        'delete_url' => \Drupal\Core\Url::fromRoute('recipe.delete', ['nid' => $node->id()]),
      ];
    }
    
    return [
      '#theme' => 'recipe_list',
      '#recipes' => $recipes,
    ];
  }
}
