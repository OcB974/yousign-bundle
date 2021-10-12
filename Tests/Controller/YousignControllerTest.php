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

        /** @var string $content */
        $content = file_get_contents(__DIR__ . '/../data/sample-webhook.json');

        $client->request('POST', '/yousign_webook/hook_handler', [], [], [], $content);

        $this->assertResponseIsSuccessful();

        $this->assertTrue($listener->onWebhookEventInvoked);

        // TODO: improve tests on headers
        $event = $listener->event;
        // $event->getHeaders();

        $content = $event->getContent();
        $this->assertEquals("/procedures/XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX", $content['id']);
        $this->assertEquals("/files/XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX", $content['files'][0]['id']);
    }
}
