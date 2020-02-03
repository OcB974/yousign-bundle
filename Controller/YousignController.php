<?php

namespace Neyric\YousignBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Neyric\YousignBundle\Event\WebhookEvent;

use Psr\Log\LoggerInterface;

class YousignController extends Controller
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
        $this->logger->debug("Yousign webhook headers", $headers);

        $event = new WebhookEvent($headers);
        $this->eventDispatcher->dispatch($event);

        return JsonResponse::create([
            'success' => true
        ]);
    }
}
