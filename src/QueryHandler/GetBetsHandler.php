<?php

namespace App\QueryHandler;

use App\Entity\Bet;
use App\Query\GetBets;
use App\Query\GetBetsPerGame;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GetBetsHandler
{
    private $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function __invoke(GetBets $query)
    {
        $repository = $this->registry->getEntityManager()->getRepository(Bet::class);

        if ($query instanceof GetBetsPerGame) {
            return $repository->findBy([
                'game' => $query->getGame(),
            ]);
        }

        return $repository->findAll();
    }
}
