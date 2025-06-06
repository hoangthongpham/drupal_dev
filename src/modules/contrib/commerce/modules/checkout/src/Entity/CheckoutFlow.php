<?php

namespace Drupal\commerce_checkout\Entity;

use Drupal\commerce\CommerceSinglePluginCollection;
use Drupal\commerce_checkout\Plugin\Commerce\CheckoutFlow\CheckoutFlowWithPanesInterface;
use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the checkout flow entity class.
 *
 * @ConfigEntityType(
 *   id = "commerce_checkout_flow",
 *   label = @Translation("Checkout flow"),
 *   label_collection = @Translation("Checkout flows"),
 *   label_singular = @Translation("checkout flow"),
 *   label_plural = @Translation("checkout flows"),
 *   label_count = @PluralTranslation(
 *     singular = "@count checkout flow",
 *     plural = "@count checkout flows",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\commerce_checkout\CheckoutFlowListBuilder",
 *     "form" = {
 *       "add" = "Drupal\commerce_checkout\Form\CheckoutFlowForm",
 *       "edit" = "Drupal\commerce_checkout\Form\CheckoutFlowForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     },
 *     "local_task_provider" = {
 *       "default" = "Drupal\entity\Menu\DefaultEntityLocalTaskProvider",
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "commerce_checkout_flow",
 *   admin_permission = "administer commerce_checkout_flow",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "plugin",
 *     "configuration",
 *   },
 *   links = {
 *     "add-form" = "/admin/commerce/config/checkout-flows/add",
 *     "edit-form" = "/admin/commerce/config/checkout-flows/manage/{commerce_checkout_flow}",
 *     "delete-form" = "/admin/commerce/config/checkout-flows/manage/{commerce_checkout_flow}/delete",
 *     "collection" =  "/admin/commerce/config/checkout-flows"
 *   }
 * )
 */
class CheckoutFlow extends ConfigEntityBase implements CheckoutFlowInterface {

  /**
   * The checkout flow ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The checkout flow label.
   *
   * @var string
   */
  protected $label;

  /**
   * The plugin ID.
   *
   * @var string
   */
  protected $plugin;

  /**
   * The plugin configuration.
   *
   * @var array
   */
  protected $configuration = [];

  /**
   * The plugin collection that holds the checkout flow plugin.
   *
   * @var \Drupal\commerce\CommerceSinglePluginCollection
   */
  protected $pluginCollection;

  /**
   * {@inheritdoc}
   */
  public function getPlugin() {
    return $this->getPluginCollection()->get($this->plugin);
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginId() {
    return $this->plugin;
  }

  /**
   * {@inheritdoc}
   */
  public function setPluginId($plugin_id) {
    $this->plugin = $plugin_id;
    $this->configuration = [];
    $this->pluginCollection = NULL;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginCollections() {
    return [
      'configuration' => $this->getPluginCollection(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function set($property_name, $value) {
    // Invoke the setter to clear related properties.
    if ($property_name == 'plugin') {
      $this->setPluginId($value);
      return $this;
    }
    else {
      return parent::set($property_name, $value);
    }
  }

  /**
   * Gets the plugin collection that holds the checkout flow plugin.
   *
   * Ensures the plugin collection is initialized before returning it.
   *
   * @return \Drupal\commerce\CommerceSinglePluginCollection
   *   The plugin collection.
   */
  protected function getPluginCollection() {
    if (!$this->pluginCollection) {
      $plugin_manager = \Drupal::service('plugin.manager.commerce_checkout_flow');
      $this->pluginCollection = new CommerceSinglePluginCollection($plugin_manager, $this->plugin, $this->configuration, $this);
    }
    return $this->pluginCollection;
  }

  /**
   * {@inheritdoc}
   */
  public function onDependencyRemoval(array $dependencies) {
    $changed = parent::onDependencyRemoval($dependencies);

    // For checkout flows with panes, ensure panes provided by the module being
    // uninstalled are removed from the configuration.
    if (!empty($dependencies['module']) &&
      $this->getPlugin() instanceof CheckoutFlowWithPanesInterface) {
      $uninstalled_modules = $dependencies['module'];
      $panes_to_remove = [];
      /** @var \Drupal\commerce_checkout\CheckoutPaneManager $pane_manager */
      $pane_manager = \Drupal::service('plugin.manager.commerce_checkout_pane');

      foreach ($pane_manager->getDefinitions() as $definition) {
        if (!in_array($definition['provider'], $uninstalled_modules, TRUE)) {
          continue;
        }
        $panes_to_remove[$definition['id']] = $definition['id'];
      }

      if ($panes_to_remove) {
        $this->configuration['panes'] = array_diff_key($this->configuration['panes'], $panes_to_remove);
        $this->getPlugin()->setConfiguration($this->configuration);
        $changed = TRUE;
      }
    }

    return $changed;
  }

}
