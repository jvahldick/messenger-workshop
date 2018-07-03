<?php

namespace App\Query;

class GetBets
{
    private $game;

    public function __construct(string $game = null)
    {
        $this->game = $game;
    }

    public static function forGame(string $game)
    {
        return new self($game);
    }

    public function getGame(): ?string
    {
        return $this->game;
    }
}
