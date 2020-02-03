<?php 

namespace Neyric\YousignBundle\Tests;

class TestWebhookListener
{
    public $onWebhookEventInvoked = false;
    public $event = null;

    public function onWebhookEvent($event)
    {
        $this->onWebhookEventInvoked = true;
        $this->event = $event;
    }

}