<?php 

namespace Neyric\YousignBundle\Tests;

use Neyric\YousignBundle\Event\WebhookEvent;

class TestWebhookListener
{
    public $onWebhookEventInvoked = false;

    /** @var WebhookEvent|null */
    public $event = null;

    public function onWebhookEvent($event)
    {
        $this->onWebhookEventInvoked = true;
        $this->event = $event;
    }

}