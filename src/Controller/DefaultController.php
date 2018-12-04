<?php

namespace App\Controller;

use App\Entity\Bet;
use App\Message\GetBets;
use App\Message\RegisterBet;
use App\Message\ReportGameResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController
{
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/")
     * @Template
     */
    public function home(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->messageBus->dispatch(new RegisterBet(
                new Bet(
                    $request->get('game'),
                    (int) $request->get('leftScore'),
                    (int) $request->get('rightScore')
                )
            ));
        }

        $envelope = $this->messageBus->dispatch(new GetBets());
        $stamp = $envelope->last(HandledStamp::class);

        return [
            'bets' => $stamp->getResult(),
        ];
    }

    /**
     * @Route("report-results", methods={"POST"}, name="report-results")
     */
    public function report(Request $request)
    {
        $this->messageBus->dispatch(new ReportGameResult(
            $request->get('game'),
            (int) $request->get('leftScore'),
            (int) $request->get('rightScore')
        ));

        return new Response('Reported.');
    }

}
