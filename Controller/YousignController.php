<?php

namespace Neyric\YousignBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Neyric\YousignBundle\Event\WebhookEvent;

use Psr\Log\LoggerInterface;

class YousignController
{
    private $eventDispatcher;
    private $logger;

    public function __construct(EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    public function webhookHandlerAction(Request $request): JsonResponse
    {
        $headers = $request->headers->all();

        /** @var array|false $webhookBody */
        $webhookBody = json_decode($request->getContent(), true);
        if ($webhookBody === false) {
            // TODO
        }

        $this->logger->debug("Yousign webhook headers", [
            'headers' => $headers,
            'content' => $webhookBody,
        ]);

        $event = new WebhookEvent($headers, $webhookBody);
        $this->eventDispatcher->dispatch($event);

        return new JsonResponse([
            'success' => true
        ]);
    }
}
