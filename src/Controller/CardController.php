<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CardType;
use App\Repository\CardRepository;
use App\Entity\Card;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
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
     * @param EntityManagerInterface $em
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("card/edition/{id}",
     *     defaults={"id": null},
     *     requirements={"id": "\d+"})
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        $id
    ) {
        if (is_null($id)) { // création
            $card = new Card();
        } else { // modification
            $card = $em->find(Card::class, $id);

            // 404 si l'id n'est pas en bdd
            if (is_null($card)) {
                throw new NotFoundHttpException();
            }
        }

        // création du formulaire relié à la catégorie
        $form = $this->createForm(CardType::class, $card);

        // le formulaire analyse la requête et fait le mapping
        // avec l'entité s'il a été soumis
        $form->handleRequest($request);

        dump($card);

        // si le formulaire a été soumis
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $centerCode =$card->getStore()->getCenterCode();
                $customerCode = $card->getUser()->getCustomerCode();
                $cardCode = (($centerCode+$customerCode)%9);
                $cardCode = (int)$cardCode;
                $card->setCheckSum($cardCode);
                // enregistrement en bdd
                $em->persist($card);
                $em->flush();

                $this->addFlash('success', 'La carte est enregistrée');

                // redirection vers la liste
                return $this->redirectToRoute('card');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'card/edit.html.twig',
            [
                // passage du formulaire au template
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Card $card
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * /**
     * @Route("card/suppression/{id}")
     */
    public function delete(Card $card
    ) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($card);
        $entityManager->flush();

        $this->addFlash('success', "La carte est supprimée");

        return $this->redirectToRoute('card');
    }
}

//centerCode =$card->getStore()->getCenterCode();
//$customerCode = $card->getUser()->getCustomerCode();
//$cardCode = $centerCode . $customerCode . (($centerCode+$customerCode)%9);
//$cardCode = (int)$cardCode;
//$card->setCheckSum($cardCode);
