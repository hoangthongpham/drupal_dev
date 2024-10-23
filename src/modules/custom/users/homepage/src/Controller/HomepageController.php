<?php

declare(strict_types=1);

namespace Drupal\homepage\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for homepage routes.
 */
final class HomepageController extends ControllerBase
{

    /**
     * Builds the response.
     */
    public function index()
    {
        return [
            '#theme' => 'homepage_template',
        ];
    }

}
