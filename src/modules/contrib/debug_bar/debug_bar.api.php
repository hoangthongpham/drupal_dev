<?php

/**
 * @file
 * Hooks provided by the Debug bar module.
 */

/**
 * @addtogroup hooks
 * @{
 */
use Drupal\debug_bar\Data\DebugBarItem;

/**
 * Alters the Debug bar items.
 *
 * @param Drupal\debug_bar\Data\DebugBarItem[] &$items
 *   Debug bar items.
 */
function hook_debug_bar_items_alter(array &$items): void {
  $module_path = \Drupal::service('extension.list.module')->getPath('example');
  $items[] = new DebugBarItem(
    id: 'example',
    content: \t('Example'),
    iconPath: \base_path() . $module_path . '/images/example.png',
    weight: 100,
  );
}

/**
 * @} End of "addtogroup hooks".
 */
