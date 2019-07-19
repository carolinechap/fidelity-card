<?php

namespace App\Controller;

use App\Card\CardGenerator;
use App\Card\CardNumberExtractor;
use App\Form\AddCardType;
use App\Form\CardType;
use App\Repository\CardRepository;
use App\Entity\Card;
use App\Validator\Constraints\IsValidCardNumber;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CardController
 * @package App\Controller
 * @Route("dashboards/carte")
 */
class CardController extends AbstractController
{
    /**
     * @Route("/", name="card_index")
     * @param CardRepository $cardRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(
        CardRepository $cardRepository,
        PaginatorInterface $paginator,
        Request $request
    )
    {
        $cards = $paginator->paginate($cardRepository->findCardByOrderStore(), $request->query->getInt('page', 1), 10);

        $lastCard = $cardRepository->findLastRecord();


        return $this->render(
            'card/index.html.twig',
            [
                'cards' => $cards,
                'last_card' => $lastCard
            ]
        );
    }

    /**
     * @Route("/creation", name="card_new", methods={"GET", "POST"})
     * @param Request $request
     * @param CardGenerator $cardGenerator
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function new(Request $request,
                        CardGenerator $cardGenerator,
                        TranslatorInterface $translator): Response
    {
        // Creation of a card
        $card = new Card();

        $form = $this->createForm(CardType::class, $card)
            ->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                // Assignment card's code (randomly)
                $card = $cardGenerator->generateCard($card);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($card);
                $entityManager->flush();

                $this->addFlash('success', $translator->trans('new.success', [], 'crud'));

                return $this->redirectToRoute('card_index');
            } else {
                $this->addFlash('error', $translator->trans('new.error', [], 'crud'));
            }
        }

        return $this->render('card/edit.html.twig', [
            'card' => $card,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/suppression/{id}", name="card_delete")
     * @param Card $card
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     */
    public function delete(Card $card, EntityManagerInterface $entityManager, TranslatorInterface $translator): RedirectResponse
    {
        $entityManager->remove($card);
        $entityManager->flush();

        $this->addFlash('success', $translator->trans('remove.success', [], 'crud'));

        return $this->redirectToRoute('card_index');
    }

    /**
     * @Route("/ajouter-client", name="card_add_user", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CardRepository $cardRepository
     * @param TranslatorInterface $translator
     * @param CardNumberExtractor $cardNumberExtractor
     * @return Response
     */
    public function addCardToUser(Request $request,
                                  EntityManagerInterface $entityManager,
                                  CardRepository $cardRepository,
                                  TranslatorInterface $translator,
                                  CardNumberExtractor $cardNumberExtractor)
    {
        if (!$user = $this->getUser()) {
            throw new UnauthorizedHttpException("Vous n'êtes pas autorisé à afficher cette page.");
        }

        $form = $this->createForm(AddCardType::class);
        $form->handleRequest($request);
        $message = null;
        $typeMessage = null;

        if ($form->isSubmitted()) {
            $cardNumber = $form->getData()['card_number'];
            if ($form->isValid()) {
                $customerCode = $cardNumberExtractor->evaluate($cardNumber);
                $card = $cardRepository->findOneBy([
                    'customerCode' => $customerCode
                ]);
                $card->setUser($user);
                $entityManager->flush();
                $message = $translator->trans('card.add.user.success', [], 'forms');
                $typeMessage = 'success';
                if (!$request->isXmlHttpRequest()) {
                    $this->addFlash('success', $message);
                }
            } else {
                $message = $translator->trans('card.add.user.error', [], 'forms');
                $typeMessage = 'danger';
                if (!$request->isXmlHttpRequest()) {
                    $this->addFlash('error', $message);
                }
            }
        }

        return $this->render('security/add_card.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
            'typeMessage' => $typeMessage
        ]);
    }
}