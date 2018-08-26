<?php

namespace App\Query;

class GetBetsPerGame implements GetBets
{
    private $game;

    public function __construct(string $game)
    {
        $this->game = $game;
    }

    public function getGame(): string
    {
        return $this->game;
    }
}