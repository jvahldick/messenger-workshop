<?php

namespace App\CommandHandler;

use App\Command\RegisterBet;
use App\Entity\Bet;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RegisterBetHandler
{
    private $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function __invoke(RegisterBet $command)
    {
        $bet = new Bet();
        $bet->game = $command->getGame();
        $bet->rightScore = $command->getRightScore();
        $bet->leftScore = $command->getLeftScore();

        $entityManager = $this->registry->getEntityManager();
        $entityManager->persist($bet);
        $entityManager->flush();
    }
}
