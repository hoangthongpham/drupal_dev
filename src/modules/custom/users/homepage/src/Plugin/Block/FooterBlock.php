<?php

declare(strict_types=1);

namespace Drupal\homepage\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a footer block.
 *
 * @Block(
 *   id = "homepage_footer",
 *   admin_label = @Translation("Footer"),
 *   category = @Translation("Custom"),
 * )
 */
final class FooterBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        $build['content'] = [
            '#theme' => 'homepage_footer',
        ];
        return $build;
    }

}
