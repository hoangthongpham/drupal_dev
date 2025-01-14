<?php

declare(strict_types=1);

namespace Drupal\debug_bar\Data;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;

/**
 * A data structure to represent a single debug bar item.
 */
final readonly class DebugBarItem {

  /**
   * {@selfdoc}
   */
  public function __construct(
    public string $id,
    public string|TranslatableMarkup $content,
    public string $iconPath,
    public bool $access = TRUE,
    public int $weight = 0,
    public ?Url $url = NULL,
    public Attribute $attributes = new Attribute(),
    public string|TranslatableMarkup|NULL $title = NULL,
  ) {}

}
