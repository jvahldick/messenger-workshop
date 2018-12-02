<?php

namespace App\Query;

abstract class GetBets
{
    private $bets = [];

    public function getBets(): array
    {
        return $this->bets;
    }
}
