<?php

namespace App\CommandHandler;

use App\Command\RegisterBet;
use App\Entity\Bet;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RegisterBetHandler
{
    private $registry;
    private $tokenStorage;

    public function __construct(RegistryInterface $registry, TokenStorageInterface $tokenStorage)
    {
        $this->registry = $registry;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(RegisterBet $command)
    {
        $bet = new Bet();
        $bet->username = $this->tokenStorage->getToken()->getUsername();
        $bet->game = $command->getGame();
        $bet->rightScore = $command->getRightScore();
        $bet->leftScore = $command->getLeftScore();

        $entityManager = $this->registry->getEntityManager();
        $entityManager->persist($bet);
        $entityManager->flush();
    }
}
