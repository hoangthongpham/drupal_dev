<?php

declare(strict_types=1);

namespace Drupal\Tests\debug_bar\Functional;

use Behat\Mink\Element\NodeElement;
use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\BrowserTestBase;

/**
 * Debug bar test.
 *
 * @group debug_bar
 */
final class DebugBarTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['debug_bar'];

  /**
   * Test callback.
   */
  public function testAsUnprivilegedUser(): void {
    $user = $this->drupalCreateUser(['view debug bar']);
    \assert($user instanceof AccountInterface);
    $this->drupalLogin($user);

    $this->drupalGet('<front>');

    $items = $this->getDebugBarItems();
    self::assertCount(8, $items);

    self::assertSame(\base_path(), $items[0]['href']);
    self::assertSame('Home', $items[0]['text']);
    self::assertNull($items[0]['title']);

    self::assertNull($items[1]['href']);
    self::assertSame('Execution time', $items[1]['title']);
    self::assertMatchesRegularExpression('#^\d+\.\d ms$#', $items[1]['text']);

    self::assertNull($items[2]['href']);
    self::assertSame('Peak memory usage', $items[2]['title']);
    self::assertMatchesRegularExpression('#^\d+ MB$#', $items[2]['text']);

    self::assertNull($items[3]['href']);
    self::assertSame('DB queries', $items[3]['title']);
    self::assertMatchesRegularExpression('#^\d+$#', $items[3]['text']);

    self::assertNull($items[4]['href']);
    self::assertSame('Current Git branch', $items[4]['title']);
    self::assertMatchesRegularExpression('#^.+$#', $items[4]['text']);

    self::assertNull($items[5]['href']);
    self::assertSame('Dynamic cache status', $items[5]['title']);
    self::assertSame('HIT', $items[5]['text']);

    self::assertSame(\base_path() . 'user/' . $user->id(), $items[6]['href']);
    self::assertSame('Open profile', $items[6]['title']);
    self::assertSame($user->getAccountName(), $items[6]['text']);

    self::assertStringContainsString(\base_path() . 'user/logout?token=', $items[7]['href']);
    self::assertNull($items[7]['title']);
    self::assertSame('Log out', $items[7]['text']);
  }

  /**
   * Test callback.
   */
  public function testAsPrivilegedUser(): void {
    $user = $this->drupalCreateUser(
      ['view debug bar', 'administer site configuration', 'access site reports'],
    );
    \assert($user instanceof AccountInterface);
    $this->drupalLogin($user);

    $this->drupalGet('<front>');

    $items = $this->getDebugBarItems();
    self::assertCount(11, $items);

    self::assertSame(\base_path(), $items[0]['href']);
    self::assertSame('Home', $items[0]['text']);
    self::assertNull($items[0]['title']);

    self::assertSame(\base_path() . 'admin/reports/status', $items[1]['href']);
    self::assertSame('Drupal version', $items[1]['title']);
    self::assertMatchesRegularExpression('#^\d+\.\d+#', $items[1]['text']);

    self::assertNull($items[2]['href']);
    self::assertSame('Execution time', $items[2]['title']);
    self::assertMatchesRegularExpression('#^\d+\.\d ms$#', $items[2]['text']);

    self::assertNull($items[3]['href']);
    self::assertSame('Peak memory usage', $items[3]['title']);
    self::assertMatchesRegularExpression('#^\d+ MB$#', $items[3]['text']);

    self::assertNull($items[4]['href']);
    self::assertSame('DB queries', $items[4]['title']);
    self::assertMatchesRegularExpression('#^\d+$#', $items[4]['text']);

    self::assertSame(\base_path() . 'admin/reports/status/php', $items[5]['href']);
    self::assertSame('PHP version', $items[5]['title']);
    self::assertMatchesRegularExpression('#^\d+\.\d+\.\d+$#', $items[5]['text']);

    self::assertStringContainsString('?debug-bar-cron=1&token=', $items[6]['href']);
    self::assertMatchesRegularExpression('#^Last run \d+ sec ago$#', $items[6]['title']);
    self::assertSame('Run cron', $items[6]['text']);

    self::assertNull($items[7]['href']);
    self::assertSame('Current Git branch', $items[7]['title']);
    self::assertMatchesRegularExpression('#^.+$#', $items[7]['text']);

    self::assertStringContainsString('?debug-bar-cache=1&token=', $items[8]['href']);
    self::assertSame('Dynamic cache status', $items[8]['title']);
    self::assertSame('HIT', $items[8]['text']);

    self::assertSame(\base_path() . 'user/' . $user->id(), $items[9]['href']);
    self::assertSame('Open profile', $items[9]['title']);
    self::assertSame($user->getAccountName(), $items[9]['text']);

    self::assertStringContainsString(\base_path() . 'user/logout?token=', $items[10]['href']);
    self::assertNull($items[10]['title']);
    self::assertSame('Log out', $items[10]['text']);
  }

  /**
   * {@selfdoc}
   *
   * @phpstan-return list<array{href: string|null, title: string|null, text: string|null}>
   */
  private function getDebugBarItems(): array {
    $get_debug_bar_item = static fn (NodeElement $item): array =>
    [
      'href' => $item->getAttribute('href'),
      'title' => $item->getAttribute('title'),
      'text' => $item->getText(),
    ];
    return \array_map($get_debug_bar_item, $this->xpath('//div[@id = "debug-bar"]/ul/li/*'));
  }

}
