<?php

namespace Neyric\YousignBundle\Controller;

use Neyric\YousignBundle\Event\WebhookEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class YousignController
{
    public function __construct(private readonly EventDispatcherInterface $eventDispatcher, private readonly LoggerInterface $logger)
    {
    }

    public function webhookHandlerAction(Request $request): JsonResponse
    {
        $headers = $request->headers->all();

        /** @var array|false $webhookBody */
        $webhookBody = json_decode($request->getContent(), true);
        if (false === $webhookBody) {
            $this->logger->error('Unable to parse JSON body content', [
                'content' => $request->getContent(),
            ]);

            return new JsonResponse([
                'success' => false,
            ]);
        }

        $this->logger->debug('Yousign webhook headers', [
            'headers' => $headers,
            'content' => $webhookBody,
        ]);

        $event = new WebhookEvent($headers, $webhookBody);
        $this->eventDispatcher->dispatch($event);

        return new JsonResponse([
            'success' => true,
        ]);
    }
}
