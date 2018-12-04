<?php

namespace App\MessageHandler;

use App\Entity\Bet;
use App\Message\LostGame;
use App\Message\ReportGameResult;
use App\Message\WonGame;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ReportGameHandler implements MessageHandlerInterface
{
    private $entityManager;
    private $bus;

    public function __construct(
        EntityManagerInterface $entityManager,
        MessageBusInterface $eventBus
    )
    {
        $this->entityManager = $entityManager;
        $this->bus = $eventBus;
    }

    public function __invoke(ReportGameResult $message)
    {
        /** @var Bet[] $bets */
        $bets = $this->entityManager
            ->getRepository(Bet::class)
            ->findBy(
                ['game' => $message->game]
            );

        foreach ($bets as $bet) {
            if ($bet->rightScore === $message->rightScore &&
                $bet->leftScore === $message->leftScore) {
                $this->bus->dispatch(new WonGame());
            } else {
                $this->bus->dispatch(new LostGame());
            }
        }
    }
}
