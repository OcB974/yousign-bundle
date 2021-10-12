<?php

namespace Neyric\YousignBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

class WebhookEvent extends Event
{
    protected $headers;
    protected $content;

    /**
     * WebhookEvent constructor.
     *
     * @param array $headers
     */
    public function __construct(array $headers, array $content)
    {
        $this->headers = $headers;
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }
}
