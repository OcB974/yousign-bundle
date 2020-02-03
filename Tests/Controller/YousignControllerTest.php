<?php

namespace Neyric\YousignBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

use Neyric\YousignBundle\Event\WebhookEvent;
use Neyric\YousignBundle\Tests\TestWebhookListener;

class YousignControllerTest extends WebTestCase
{
    public function testWebhookHandlerAction()
    {
        $client = static::createClient();


        // Access the kernel container (booted from createClient)
        $container = static::$kernel->getContainer();

        // Subscribe a test listener
        $dispatcher = $container->get('event_dispatcher');
        $listener = new TestWebhookListener();
        $dispatcher->addListener(WebhookEvent::class, [$listener, 'onWebhookEvent']);


        $client->request('GET', '/yousign_webook/hook_handler');

        // $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();

        $this->assertTrue($listener->onWebhookEventInvoked);

        $event = $listener->event;
        $event->getHeaders();

    }
}
