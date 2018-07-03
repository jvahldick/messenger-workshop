<?php

namespace App\Middleware;

use Symfony\Component\Messenger\EnvelopeItemInterface;

class AuditEnvelopeItem implements EnvelopeItemInterface
{
    private $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return $this->uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->uuid = $serialized;
    }
}
