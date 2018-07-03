<?php

namespace App\QueryHandler;

use App\Entity\Bet;
use App\Query\GetBets;
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

        return $query->getGame() === null ? $repository->findAll() : $repository->findBy([
            'game' => $query->getGame(),
        ]);
    }
}
