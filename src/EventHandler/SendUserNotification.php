<?php

namespace App\EventHandler;

use App\Event\LostBet;
use App\Event\WonBet;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class SendUserNotification implements MessageSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getHandledMessages(): iterable
    {
        return [
            WonBet::class,
            LostBet::class,
        ];
    }

    public function __invoke($event)
    {
        if ($event instanceof WonBet) {
            echo sprintf(
                'User "%s" has lost the bet. The %s game has actually ended with the score of %d-%d.',
                $event->getBet()->username,
                $event->getBet()->game,
                $event->getBet()->leftScore,
                $event->getBet()->rightScore
            );
        } elseif ($event instanceof LostBet) {
            echo sprintf(
                'User "%s" has won the bet on the %s game. Well done!',
                $event->getBet()->username,
                $event->getBet()->game
            );
        }
    }
}
