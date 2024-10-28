<?php

namespace Neyric\YousignBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

class WebhookEvent extends Event
{
    protected array $headers;
    protected array $content;

    /**
     * WebhookEvent constructor.
     *
     * @param array $headers
     * @param array $content
     */
    public function __construct(array $headers, array $content)
    {
        $this->headers = $headers;
        $this->content = $content;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
