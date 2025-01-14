<?php

declare(strict_types=1);

namespace Drupal\debug_bar;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Component\Render\MarkupInterface;
use Drupal\Component\Utility\Html;
use Drupal\Core\Access\CsrfTokenGenerator;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup as TM;
use Drupal\Core\Url;
use Drupal\debug_bar\Data\DebugBarItem;

/**
 * {@selfdoc}
 */
final readonly class DebugBarBuilder {

  public const string CRON_KEY = 'debug-bar-cron';
  public const string CACHE_KEY = 'debug-bar-cache';

  /**
   * {@selfdoc}
   */
  public function __construct(
    private AccountInterface $currentUser,
    private ModuleHandlerInterface $moduleHandler,
    private ConfigFactoryInterface $config,
    private StateInterface $state,
    private DateFormatterInterface $dateFormatter,
    private CsrfTokenGenerator $csrfTokenGenerator,
    private RendererInterface $renderer,
    private TimeInterface $time,
    private ModuleExtensionList $moduleList,
  ) {}

  /**
   * Builds debug bar.
   */
  public function build(): MarkupInterface {
    $debug_bar = [
      '#theme' => 'debug_bar',
      '#attributes' => [
        'id' => 'debug-bar',
        'class' => [
          'debug-bar',
          'debug-bar_' . Html::cleanCssIdentifier($this->config->get('debug_bar.settings')->get('position')),
          'debug-bar_hidden',
        ],
      ],
      '#items' => \array_filter($this->buildItems(), static fn (DebugBarItem $item): bool => $item->access),
    ];
    return $this->renderer->renderInIsolation($debug_bar);
  }

  /**
   * Returns elements for debug bar.
   *
   * @phpstan-return \Drupal\debug_bar\Data\DebugBarItem[]
   */
  private function buildItems(): array {
    // CSRF tokens depend on session data so the user must be authenticated.
    $is_admin = $this->currentUser->isAuthenticated() &&
      $this->currentUser->hasPermission('administer site configuration');
    $images_path = \base_path() . $this->moduleList->getPath('debug_bar') . '/images';

    $items[] = new DebugBarItem(
      id: 'home',
      content: new TM('Home'),
      iconPath: $images_path . '/home.png',
      weight: 10,
      url: Url::fromRoute('<front>'),
    );

    $items[] = new DebugBarItem(
      id: 'status_report',
      content: \Drupal::VERSION,
      iconPath: $images_path . '/druplicon.png',
      access: $this->currentUser->hasPermission('access site reports'),
      weight: 20,
      url: Url::fromRoute('system.status'),
      title: new TM('Drupal version'),
    );

    $items[] = new DebugBarItem(
      id: 'execution_time',
      content: new TM('@time ms', ['@time' => '[execution_time]']),
      iconPath: $images_path . '/time.png',
      weight: 30,
      title: new TM('Execution time'),
    );

    $items[] = new DebugBarItem(
      id: 'memory_usage',
      content: new TM('@memory MB', ['@memory' => '[memory_usage]']),
      iconPath: $images_path . '/memory.png',
      weight: 40,
      title: new TM('Peak memory usage'),
    );

    $items[] = new DebugBarItem(
      id: 'db_queries',
      content: '[db_queries]',
      iconPath: $images_path . '/db-queries.png',
      weight: 50,
      title: new TM('DB queries'),
    );

    $items[] = new DebugBarItem(
      id: 'php',
      content: \phpversion(),
      iconPath: $images_path . '/php.png',
      access: $is_admin,
      weight: 60,
      url: Url::fromRoute('system.php'),
      title: new TM('PHP version'),
    );

    $cron_last = $this->state->get('system.cron_last');

    $query = [
      self::CRON_KEY => '1',
      'token' => $this->csrfTokenGenerator->get(self::CRON_KEY),
    ];
    $items[] = new DebugBarItem(
      id: 'cron',
      content: new TM('Run cron'),
      iconPath: $images_path . '/cron.png',
      access: $is_admin,
      weight: 70,
      url: Url::fromRoute('<current>', options: ['query' => $query]),
      title: new TM(
        'Last run @time ago',
        ['@time' => $this->dateFormatter->formatInterval($this->time->getRequestTime() - $cron_last)]
      ),
    );

    // Drupal can be installed to a subdirectory of Git root.
    $git_branch = self::getGitBranch(DRUPAL_ROOT) ?: self::getGitBranch(DRUPAL_ROOT . '/..');

    $items[] = new DebugBarItem(
      id: 'git',
      content: (string) $git_branch,
      iconPath: $images_path . '/git.png',
      access: $git_branch !== NULL,
      weight: 80,
      title: new TM('Current Git branch'),
    );

    if ($this->moduleHandler->moduleExists('dblog')) {
      $items[] = new DebugBarItem(
        id: 'watchdog',
        content: new TM('Log'),
        iconPath: $images_path . '/log.png',
        access: $this->currentUser->hasPermission('access site reports'),
        weight: 90,
        url: Url::fromRoute('dblog.overview'),
        title: new TM('Recent log messages'),
      );
    }

    $url = NULL;
    if ($is_admin) {
      $query = [
        self::CACHE_KEY => '1',
        'token' => $this->csrfTokenGenerator->get(self::CACHE_KEY),
      ];
      $url = new Url('<current>', options: ['query' => $query]);
    }
    $items[] = new DebugBarItem(
      id: 'cache',
      content: $this->currentUser->isAuthenticated() ? '[dynamic_cache]' : '[anonymous_cache]',
      iconPath: $images_path . '/cache.png',
      weight: 100,
      url: $url,
      title: $this->currentUser->isAuthenticated() ?
        new TM('Dynamic cache status') : new TM('Anonymous cache status'),
    );

    if ($this->currentUser->isAnonymous()) {
      $items[] = new DebugBarItem(
        id: 'login',
        content: new TM('Log in'),
        iconPath: $images_path . '/user.png',
        weight: 110,
        url: Url::fromRoute('user.login'),
      );
    }
    else {
      $items[] = new DebugBarItem(
        id: 'user',
        content: (string) $this->currentUser->getDisplayName(),
        iconPath: $images_path . '/user.png',
        weight: 120,
        url: Url::fromRoute('entity.user.canonical', ['user' => $this->currentUser->id()]),
        title: new TM('Open profile'),
      );

      $items[] = new DebugBarItem(
        id: 'logout',
        content: new TM('Log out'),
        iconPath: $images_path . '/logout.png',
        weight: 130,
        url: Url::fromRoute('user.logout'),
      );
    }

    $this->moduleHandler->alter('debug_bar_items', $items);
    \uasort($items, static fn (DebugBarItem $a, DebugBarItem $b): int => $a->weight <=> $b->weight);
    return $items;
  }

  /**
   * Returns the current Git branch name.
   */
  private static function getGitBranch(string $directory): ?string {
    $file = $directory . '/.git/HEAD';
    if (@\is_readable($file) && ($data = \file_get_contents($file)) && ($data = \explode('/', $data))) {
      return \rtrim(\end($data));
    }
    return NULL;
  }

}
