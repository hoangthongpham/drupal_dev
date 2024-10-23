<?php

declare(strict_types=1);

namespace Drupal\homepage\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Menu\MenuTreeParameters;

/**
 * Provides a header block.
 *
 * @Block(
 *   id = "homepage_header",
 *   admin_label = @Translation("Header"),
 *   category = @Translation("Custom"),
 * )
 */
final class HeaderBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        $mainMenu = \Drupal::menuTree()->load('main', new MenuTreeParameters);

        $build['content'] = [
            '#theme' => 'homepage_header',
            '#data' => [
                'menu-items' => $this->getMenus($mainMenu)
            ]
        ];
        return $build;
    }


    function getMenus($tree)
    {
        $menu = [];
        foreach ($tree as $item) {
            if ($item->link->isEnabled()) {
                $menu[] = [
                    'weight' => $item->link->getWeight(),
                    'title' => $item->link->getTitle(),
                    'url' => $item->link->getUrlObject(),
                    'has_children' => $item->hasChildren,
                    'children' => $this->getMenus($item->subtree),
                ];
            }
        }
        return $menu;
    }

}
