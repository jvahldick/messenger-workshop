<?php

namespace App\Controller;

use App\Command\RegisterBet;
use App\Command\ReportGameResult;
use App\Query\GetBets;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class Homepage extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home(MessageBusInterface $bus)
    {
        return $this->render('home.html.twig', [
            'bets' => $bus->dispatch(new GetBets()),
        ]);
    }

    /**
     * @Route("/register-bet", methods={"POST"}, name="register_bet")
     */
    public function registerBet(Request $request, MessageBusInterface $bus, TokenStorageInterface $tokenStorage)
    {
        // Never do this. I'm faking the authentication.
        $tokenStorage->setToken(new UsernamePasswordToken($request->get('email'), null, 'main'));

        $bus->dispatch(new RegisterBet(
            $request->get('game'),
            $request->get('left-score'),
            $request->get('right-score')
        ));

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/report-game-result", methods={"POST"}, name="report_game_result")
     */
    public function reportGameResult(Request $request, MessageBusInterface $bus)
    {
        $bus->dispatch(new ReportGameResult(
            $request->get('game'),
            $request->get('left-score'),
            $request->get('right-score')
        ));

        return $this->redirectToRoute('home');
    }
}
