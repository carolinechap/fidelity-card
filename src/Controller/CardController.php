<?php

namespace App\Controller;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Card\CardGenerator;
use App\Form\CardType;
use App\Repository\CardRepository;
use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardController
 * @package App\Controller
 * @Route("/carte")
 */
class CardController extends AbstractController
{
    /**
     * @Route("/", name="card_index")
     */
    public function index(
        CardRepository $cardRepository
            ) {
        $cards = $cardRepository->findBy(
            [],
            [
                'checkSum' => 'DESC'
            ]
        );
        return $this->render(
            'card/index.html.twig',
            [
                'cards' => $cards
            ]
        );
    }

    /**
     * @param Request $request
     * @param CardGenerator $cardGenerator
     * @return Response
     * @Route("/creation", name="card_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CardGenerator $cardGenerator): Response
    {
        # Création d'une nouvelle carte
        $card = new Card();

        $form = $this->createForm(CardType::class, $card)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            # Process de création d'une carte ...
            $card = $cardGenerator->generateCard($card);

            # Sauvegarde de la carte
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($card);
            $entityManager->flush();

            return $this->redirectToRoute('card_index');
        }
        return $this->render('card/edit.html.twig', [
            'card' => $card,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/suppression/{id}", name="card_delete")
     */
    public function delete(Card $card, EntityManagerInterface $entityManager
    ) {
        $entityManager->remove($card);
        $entityManager->flush();

        $this->addFlash('success', "La carte est supprimée");

        return $this->redirectToRoute('card_index');
    }


}

//centerCode =$card->getStore()->getCenterCode();
//$customerCode = $card->getUser()->getCustomerCode();
//$cardCode = $centerCode . $customerCode . (($centerCode+$customerCode)%9);
//$cardCode = (int)$cardCode;
//$card->setCheckSum($cardCode);
