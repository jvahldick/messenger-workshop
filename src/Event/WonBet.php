<?php

namespace App\Event;

use App\Entity\Bet;

class WonBet
{
    private $bet;

    public function __construct(Bet $bet)
    {
        $this->bet = $bet;
    }

    public function getBet(): Bet
    {
        return $this->bet;
    }
}
