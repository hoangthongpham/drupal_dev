<?php

declare(strict_types=1);

namespace Drupal\homepage\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a slider block.
 *
 * @Block(
 *   id = "homepage_slider",
 *   admin_label = @Translation("Slider"),
 *   category = @Translation("Custom"),
 * )
 */
final class SliderBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build(): array
    {
        $build['content'] = [
            '#theme' => 'homepage_slider',
        ];
        return $build;
    }

}
