<?php

namespace App\MessageHandler;

use App\Message\RegisterBet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisterBetHandler implements MessageHandlerInterface
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(RegisterBet $message)
    {
        $this->entityManager->persist(
            $message->bet
        );

        $this->entityManager->flush();
    }
}
