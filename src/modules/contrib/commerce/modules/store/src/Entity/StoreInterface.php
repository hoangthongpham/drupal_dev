<?php

namespace Drupal\commerce_store\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\address\AddressInterface;
use Drupal\commerce_price\Entity\CurrencyInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Defines the interface for stores.
 */
interface StoreInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the store name.
   *
   * @return string
   *   The store name.
   */
  public function getName();

  /**
   * Sets the store name.
   *
   * @param string $name
   *   The store name.
   *
   * @return $this
   */
  public function setName($name);

  /**
   * Gets the store email.
   *
   * @return string
   *   The store email.
   */
  public function getEmail();

  /**
   * Gets the store email formatted as email 'From' header.
   *
   * Example: 'My Store <mystore@example.com>'
   *
   * @return string
   *   The store name, with email wrapped in angle brackets.
   */
  public function getEmailFromHeader();

  /**
   * Sets the store email.
   *
   * @param string $mail
   *   The store email.
   *
   * @return $this
   */
  public function setEmail($mail);

  /**
   * Gets the default store currency.
   *
   * @return \Drupal\commerce_price\Entity\CurrencyInterface
   *   The default store currency.
   */
  public function getDefaultCurrency();

  /**
   * Sets the default store currency.
   *
   * @param \Drupal\commerce_price\Entity\CurrencyInterface $currency
   *   The default store currency.
   *
   * @return $this
   */
  public function setDefaultCurrency(CurrencyInterface $currency);

  /**
   * Gets the default store currency code.
   *
   * @return string
   *   The default store currency code.
   */
  public function getDefaultCurrencyCode();

  /**
   * Sets the default store currency code.
   *
   * @param string $currency_code
   *   The default store currency code.
   *
   * @return $this
   */
  public function setDefaultCurrencyCode($currency_code);

  /**
   * Gets the store timezone.
   *
   * Used when determining promotion and tax availability.
   *
   * @return string
   *   The timezone.
   */
  public function getTimezone();

  /**
   * Sets the store timezone.
   *
   * @param string $timezone
   *   The timezone.
   *
   * @return $this
   */
  public function setTimezone($timezone);

  /**
   * Gets the store address.
   *
   * @return \Drupal\address\AddressInterface
   *   The store address.
   */
  public function getAddress();

  /**
   * Sets the store address.
   *
   * @param \Drupal\address\AddressInterface $address
   *   The store address.
   *
   * @return $this
   */
  public function setAddress(AddressInterface $address);

  /**
   * Gets the store billing countries.
   *
   * If empty, it's assumed that all countries are supported.
   *
   * @return array
   *   A list of country codes.
   */
  public function getBillingCountries();

  /**
   * Sets the store billing countries.
   *
   * @param array $countries
   *   A list of country codes.
   *
   * @return $this
   */
  public function setBillingCountries(array $countries);

  /**
   * Gets whether this is the default store.
   *
   * @return bool
   *   TRUE if this is the default store, FALSE otherwise.
   */
  public function isDefault();

  /**
   * Sets whether this is the default store.
   *
   * @param bool $is_default
   *   Whether this is the default store.
   *
   * @return $this
   */
  public function setDefault($is_default);

  /**
   * Gets the store creation timestamp.
   *
   * @return int
   *   The store creation timestamp.
   */
  public function getCreatedTime();

  /**
   * Sets the store creation timestamp.
   *
   * @param int $timestamp
   *   The store creation timestamp.
   *
   * @return $this
   */
  public function setCreatedTime($timestamp);

}
