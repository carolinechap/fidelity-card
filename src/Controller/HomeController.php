<?php

namespace App\Controller;

use App\Entity\Card;
use App\Events\AppEvents;
use App\Events\CardFidelityPointEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="home")
     */
    public function index(EventDispatcherInterface $eventDispatcher)
    {

        if ($this->getUser()) {
            $user = $this->getUser();

            $cardRepository = $this->getDoctrine()->getRepository(Card::class);

            $cardsUser = $cardRepository->findCardByUser($user);

            foreach ($cardsUser as $cardUser) {
                //On déclenche l'événement' correspondant
                $event = new CardFidelityPointEvent($cardUser);
                if ($event->fidelityPointsAttained() === true) {
                    $eventDispatcher->dispatch($event, AppEvents::CARD_FIDELITY_POINTS);
                }
            }

            return $this->render('home/index.html.twig', [
                'cards_user' => $cardsUser
            ]);
        }

        return $this->render('home/index.html.twig');

    }


}
