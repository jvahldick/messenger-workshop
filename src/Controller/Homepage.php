<?php

namespace App\Controller;

use App\Command\RegisterBet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class Homepage extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/register-bet", methods={"POST"}, name="register_bet")
     */
    public function registerBet(Request $request, MessageBusInterface $bus)
    {
        $bus->dispatch(new RegisterBet(
            $request->get('game'),
            $request->get('left-score'),
            $request->get('right-score')
        ));

        return $this->redirectToRoute('home');
    }
}
