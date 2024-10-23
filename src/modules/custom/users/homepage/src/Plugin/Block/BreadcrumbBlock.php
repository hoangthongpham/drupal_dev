<?php

declare(strict_types=1);

namespace Drupal\homepage\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a breadcrumb block.
 *
 * @Block(
 *   id = "homepage_breadcrumb",
 *   admin_label = @Translation("Breadcrumb"),
 *   category = @Translation("Custom"),
 * )
 */
final class BreadcrumbBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        $build['content'] = [
            '#theme' => 'homepage_breadcrumb',
        ];
        return $build;
    }

}
