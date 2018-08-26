<?php

namespace App\CommandHandler;

use App\Command\ReportGameResult;
use App\Entity\Bet;
use App\Event\LostBet;
use App\Event\WonBet;
use App\Query\GetBets;
use App\Query\GetBetsPerGame;
use Symfony\Component\Messenger\MessageBusInterface;

class ReportGameResultHandler
{
    private $bus;
    private $eventBus;

    public function __construct(MessageBusInterface $bus, MessageBusInterface $eventBus)
    {
        $this->bus = $bus;
        $this->eventBus = $eventBus;
    }

    public function __invoke(ReportGameResult $command)
    {
        /** @var Bet[] $bets */
        $bets = $this->bus->dispatch(new GetBetsPerGame($command->getGame()));

        foreach ($bets as $bet) {
            $this->eventBus->dispatch(
                $this->isWinning($bet, $command) ? new WonBet($bet) : new LostBet($bet)
            );
        }
    }

    private function isWinning(Bet $bet, ReportGameResult $command)
    {
        return $bet->leftScore === $command->getLeftScore() && $bet->rightScore === $command->getRightScore();
    }
}
