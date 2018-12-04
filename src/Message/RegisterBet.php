<?php

namespace App\Message;

use App\Entity\Bet;

class RegisterBet
{
    public $bet;

    public function __construct(Bet $bet)
    {
        $this->bet = $bet;
    }
}
