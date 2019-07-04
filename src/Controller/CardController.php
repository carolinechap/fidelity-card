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
     * @Route("/edition/{id}",
     *     defaults={"id": null},
     *     requirements={"id": "\d+"}, name="card_edit")
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

        // si le formulaire a été soumis
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $checkSum = $card->defineCheckSum();
                $card->setCheckSum($checkSum);

                $cardCode = $card->defineCardCode();
                $card->setCardCode($cardCode);

                dd($card);


                // enregistrement en bdd
                $em->persist($card);
                $em->flush();

                $this->addFlash('success', 'La carte est enregistrée');

                // redirection vers la liste
                return $this->redirectToRoute('card_index');
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
