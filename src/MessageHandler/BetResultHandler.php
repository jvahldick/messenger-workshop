<?php

namespace App\MessageHandler;

use App\Message\BetResultMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class BetResultHandler implements MessageSubscriberInterface
{
    public function sendNotification(BetResultMessage $message)
    {
        var_dump($message);
    }

    /**
     * {@inheritdoc}
     */
    public static function getHandledMessages(): iterable
    {
        yield BetResultMessage::class => [
            'bus' => 'event_bus',
            'method' => 'sendNotification',
        ];
    }
}
