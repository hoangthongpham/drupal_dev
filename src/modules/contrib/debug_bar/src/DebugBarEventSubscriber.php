<?php

declare(strict_types=1);

namespace Drupal\debug_bar;

use Drupal\Core\Access\CsrfTokenGenerator;
use Drupal\Core\CronInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\Render\AttachmentsInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup as TM;
use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Debug bar event subscriber.
 */
final class DebugBarEventSubscriber implements EventSubscriberInterface {

  use MessengerTrait;

  /**
   * {@selfdoc}
   */
  public function __construct(
    private readonly AccountInterface $currentUser,
    private readonly CronInterface $cron,
    private readonly CsrfTokenGenerator $csrfTokenGenerator,
    private readonly DebugBarBuilder $builder,
  ) {}

  /**
   * Request listener.
   */
  public function onKernelRequest(RequestEvent $event): void {

    if (!$this->currentUser->hasPermission('administer site configuration')) {
      return;
    }

    if (!$this->currentUser->hasPermission('view debug bar')) {
      return;
    }

    $request = $event->getRequest();

    $token = $request->query->get('token');
    if (!\is_string($token)) {
      return;
    }

    if ($request->get(DebugBarBuilder::CRON_KEY) && $this->csrfTokenGenerator->validate($token, DebugBarBuilder::CRON_KEY)) {
      $this->cron->run();
      $this->messenger()->addStatus(new TM('Cron ran successfully.'));
      $event->setResponse(new RedirectResponse(Url::fromRoute('<current>')->toString()));
    }

    if ($request->get(DebugBarBuilder::CACHE_KEY) && $this->csrfTokenGenerator->validate($token, DebugBarBuilder::CACHE_KEY)) {
      \drupal_flush_all_caches();
      $this->messenger()->addStatus(new TM('Caches cleared.'));
      $event->setResponse(new RedirectResponse(Url::fromRoute('<current>')->toString()));
    }
  }

  /**
   * Response listener.
   */
  public function onKernelResponse(ResponseEvent $event): void {
    $response = $event->getResponse();
    $is_allowed = !$response->isRedirection() &&
                  $response instanceof AttachmentsInterface &&
                  $event->isMainRequest() &&
                  !$event->getRequest()->isXmlHttpRequest() &&
                  $this->currentUser->hasPermission('view debug bar');
    if ($is_allowed) {
      $response->addAttachments(['debug_bar' => $this->builder->build()]);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      // Run after AuthenticationSubscriber.
      KernelEvents::REQUEST => ['onKernelRequest', 250],
      KernelEvents::RESPONSE => ['onKernelResponse'],
    ];
  }

}
