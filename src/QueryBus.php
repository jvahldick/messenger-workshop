<?php

namespace App;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus
{
    use HandleTrait;

    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function query($query)
    {
        return $this->handle($query);
    }
}
