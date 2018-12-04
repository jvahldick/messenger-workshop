<?php

namespace App\Controller;

use App\Entity\Bet;
use App\Message\GetBets;
use App\Message\RegisterBet;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController
{
    /**
     * @Route("/")
     * @Template
     */
    public function home(
        MessageBusInterface $messageBus,
        Request $request
    )
    {
        if ($request->isMethod('post')) {
            $messageBus->dispatch(new RegisterBet(
                new Bet(
                    $request->get('game'),
                    (int) $request->get('leftScore'),
                    (int) $request->get('rightScore')
                )
            ));
        }

        $envelope = $messageBus->dispatch(new GetBets());
        $stamp = $envelope->last(HandledStamp::class);

        return [
            'bets' => $stamp->getResult(),
        ];
    }
}
