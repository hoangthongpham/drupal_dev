<?php

declare(strict_types=1);

namespace Drupal\Tests\debug_bar\Functional;

use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\BrowserTestBase;

/**
 * A test for debug bar actions.
 *
 * @group debug_bar
 */
final class ActionsTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['debug_bar', 'page_cache', 'dynamic_page_cache'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $permissions = ['view debug bar', 'administer site configuration'];
    $user = $this->drupalCreateUser($permissions);
    \assert($user instanceof AccountInterface);
    $this->drupalLogin($user);
  }

  /**
   * Test callback.
   */
  public function testHomePageLink(): void {
    $this->drupalGet('/some-page');
    $this->click('.debug-bar li:first-child a');
    // By default, home page is set to user profile for authenticated users.
    $this->assertSession()->addressEquals('/user/' . $this->loggedInUser->id());
  }

  /**
   * Test callback.
   */
  public function testPhpLink(): void {
    $this->click('.debug-bar a[title="PHP version"]');
    $this->assertSession()->addressEquals('/admin/reports/status/php');
  }

  /**
   * Test callback.
   */
  public function testRunCron(): void {
    $state = $this->container->get('state');
    $cron_last_before = $state->get('system.cron_last');

    // Wait a bit to change request time.
    sleep(1);
    $this->click('.debug-bar a[href*="?debug-bar-cron=1"]');
    $this->assertSession()->pageTextContains('Cron ran successfully.');

    $state->resetCache();
    $cron_last_after = $state->get('system.cron_last');
    self::assertGreaterThan($cron_last_before, $cron_last_after);
  }

  /**
   * Test callback.
   */
  public function testClearCaches(): void {
    $this->click('.debug-bar a[href*="?debug-bar-cache=1"]');
    $this->assertSession()->pageTextContains('Caches cleared.');
  }

  /**
   * Test callback.
   */
  public function testUserProfileLink(): void {
    $this->drupalGet('/some-page');
    $this->click('.debug-bar a[title="Open profile"]');
    $this->assertSession()->addressEquals('/user/' . $this->loggedInUser->id());
  }

  /**
   * Test callback.
   */
  public function testLogOutLink(): void {
    $this->drupalGet('/some-page');
    $this->click('.debug-bar a[href*="/user/logout"]');
    $this->assertSession()->addressEquals('/');
  }

}
