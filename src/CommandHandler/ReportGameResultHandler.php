<?php

namespace App\CommandHandler;

use App\Command\ReportGameResult;
use App\Entity\Bet;
use App\Query\GetBets;
use Symfony\Component\Messenger\MessageBusInterface;

class ReportGameResultHandler
{
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(ReportGameResult $command)
    {
        /** @var Bet[] $bets */
        $bets = $this->bus->dispatch(GetBets::forGame($command->getGame()));
        dd($bets);
    }
}
