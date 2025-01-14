<?php

declare(strict_types=1);

namespace Drupal\debug_bar;

use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Database;
use Drupal\Core\Render\AttachmentsInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Debug Bar Middleware.
 *
 * The middleware may run on a non-fully functional Drupal instance. That may
 * happen when a response comes from page cache module. In this case some Drupal
 * sub-systems are not initialized yet. For that reason the debug bar is built
 * in event subscriber. However, some performance metrics are added here through
 * placeholder interpolation. This makes them more accurate and helps to avoid
 * caching issues.
 *
 * @see \Drupal\debug_bar\DebugBarEventSubscriber
 */
final readonly class DebugBarMiddleware implements HttpKernelInterface {

  /**
   * {@selfdoc}
   */
  public function __construct(
    private HttpKernelInterface $httpKernel,
    private Connection $connection,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function handle(Request $request, $type = self::MAIN_REQUEST, $catch = TRUE): Response {
    Database::startLog('debug_bar');

    $response = $this->httpKernel->handle($request, $type, $catch);

    if ($response instanceof AttachmentsInterface) {
      $this->injectDebugBar($request, $response);
    }

    return $response;
  }

  /**
   * Injects debug bar into response body.
   */
  private function injectDebugBar(Request $request, Response&AttachmentsInterface $response): void {

    $debug_bar = $response->getAttachments()['debug_bar'] ?? NULL;
    if (!$debug_bar) {
      return;
    }

    $execution_time = 1_000 * (\microtime(TRUE) - $request->server->get('REQUEST_TIME_FLOAT'));
    $db_queries = $this->connection->getLogger()->get('debug_bar');
    $memory_usage = \memory_get_peak_usage(TRUE) / 1_024 / 1_024;
    $anonymous_cache = $response->headers->get('X-Drupal-Cache') ?: 'NONE';
    $dynamic_cache = $response->headers->get('X-Drupal-Dynamic-Cache') ?: 'NONE';

    $tokens = [
      '[execution_time]' => \number_format($execution_time, 1, '.', ''),
      '[db_queries]' => (string) \count($db_queries),
      '[memory_usage]' => \round($memory_usage),
      '[anonymous_cache]' => $anonymous_cache,
      '[dynamic_cache]' => $dynamic_cache,
    ];
    $debug_bar = \strtr((string) $debug_bar, $tokens);

    $response->setContent(
      \str_replace('</body>', $debug_bar . '</body>', (string) $response->getContent()),
    );

    // Set content length conditionally to not break other response modifiers.
    // @see https://www.drupal.org/node/3298551
    $content_length = $response->headers->get('Content-Length');
    if ($content_length) {
      $response->headers->set('Content-Length', (string) \strlen((string) $response->getContent()));
    }
  }

}
