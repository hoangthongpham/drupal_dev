<?php

declare(strict_types=1);

namespace Drupal\Tests\debug_bar\Functional;

use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\BrowserTestBase;

/**
 * Settings form test.
 *
 * @group debug_bar
 */
final class SettingsFormTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['debug_bar'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $user = $this->drupalCreateUser(['administer debug bar', 'view debug bar']);
    \assert($user instanceof AccountInterface);
    $this->drupalLogin($user);
  }

  /**
   * Test callback.
   */
  public function testSettingsForm(): void {
    $this->drupalGet('admin/config/development/debug-bar');
    $this->assertXpath('//h1[text() = "Debug bar"]');
    $this->assertXpath('//form/fieldset/legend/span[text() = "Position"]');
    $this->assertXpath('//form//input[@type = "radio" and @checked = "checked"]/following-sibling::label[text() = "Bottom right"]');
    self::assertSame('bottom_right', $this->getPosition());

    $this->submitForm(['position' => 'top_left'], 'Save configuration');
    $this->assertSession()->pageTextContains('The configuration options have been saved.');
    self::assertSame('top_left', $this->getPosition());
    $this->assertXpath('//div[@id = "debug-bar" and contains(@class, "debug-bar_top-left")]');

    $this->submitForm(['position' => 'top_right'], 'Save configuration');
    $this->assertSession()->pageTextContains('The configuration options have been saved.');
    self::assertSame('top_right', $this->getPosition());
    $this->assertXpath('//div[@id = "debug-bar" and contains(@class, "debug-bar_top-right")]');

    $this->submitForm(['position' => 'bottom_left'], 'Save configuration');
    $this->assertSession()->pageTextContains('The configuration options have been saved.');
    self::assertSame('bottom_left', $this->getPosition());
    $this->assertXpath('//div[@id = "debug-bar" and contains(@class, "debug-bar_bottom-left")]');

    $this->submitForm(['position' => 'bottom_right'], 'Save configuration');
    $this->assertSession()->pageTextContains('The configuration options have been saved.');
    self::assertSame('bottom_right', $this->getPosition());
    $this->assertXpath('//div[@id = "debug-bar" and contains(@class, "debug-bar_bottom-right")]');

    $this->drupalLogout();
    $this->drupalGet('admin/config/development/debug-bar');
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Returns debug bar position.
   */
  private function getPosition(): string {
    return $this->container->get('config.factory')->get('debug_bar.settings')->get('position');
  }

  /**
   * Asserts element by xpath.
   */
  private function assertXpath(string $xpath): void {
    $this->assertSession()->elementExists('xpath', $xpath);
  }

}
