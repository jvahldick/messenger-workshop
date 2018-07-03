<?php

namespace App\Command;

class RegisterBet
{
    private $game;
    private $leftScore;
    private $rightScore;

    public function __construct(string $game, int $leftScore, int $rightScore)
    {
        if (strlen($game) !== 6) {
            throw new \InvalidArgumentException(sprintf(
                'Game needs to be a 6 letter code like "FRABRE" but found "%s"',
                $game
            ));
        }

        $this->game = $game;
        $this->leftScore = $leftScore;
        $this->rightScore = $rightScore;
    }

    public function getGame(): string
    {
        return $this->game;
    }

    public function getLeftScore(): int
    {
        return $this->leftScore;
    }

    public function getRightScore(): int
    {
        return $this->rightScore;
    }
}
