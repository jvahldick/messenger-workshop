<?php

namespace App\Controller;

use App\Message\RegisterBet;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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
                $request->get('game'),
                (int) $request->get('leftScore'),
                (int) $request->get('rightScore')
            ));
        }

        return [];
    }
}
