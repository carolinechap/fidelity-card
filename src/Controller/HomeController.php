<?php

namespace App\Controller;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Card\CardNumberExtractor;
use App\Entity\Card;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        if ($this->getUser()) {
            $user = $this->getUser();

            $cardRepository = $this->getDoctrine()->getRepository(Card::class);

            $cardsUser = $cardRepository->findCardByUser($user);

            return $this->render('home/index.html.twig', [
                'cards_user' => $cardsUser
            ]);
        }

        return $this->render('home/index.html.twig');

    }


}
