<?php

namespace App\Controller;

use App\Card\CardGenerator;
use App\Card\CardNumberExtractor;
use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Form\AddCardType;
use App\Form\CardType;
use App\Repository\CardRepository;
use App\Entity\Card;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use App\Validator\Constraints\IsValidCardNumber;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        CardRepository $cardRepository,
        PaginatorInterface $paginator,
        Request $request
            ) {
        $cards = $paginator->paginate($cardRepository->findCardByOrderStore(), $request->query->getInt('page', 1), 10);


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

            # Handle Workflow
            $workflow = $this->registry->get($card);
            if ($workflow->can($card, 'preactivating')) {
                try {
                    $workflow->apply($card, 'preactivating');
                } catch (LogicException $e) {
                    # Transition non autorisé
                    $e->getMessage();
                }
            }

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
     * @param Card $card
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/suppression/{id}", name="card_delete")
     */
    public function delete(Card $card, EntityManagerInterface $entityManager) : RedirectResponse
    {
        $entityManager->remove($card);
        $entityManager->flush();

        $this->addFlash('success', "La carte est supprimée");

        return $this->redirectToRoute('card_index');
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CardRepository $cardRepository
     * @param TranslatorInterface $translator
     * @param CardNumberExtractor $cardNumberExtractor
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     * @Route("/ajouter-client", name="card_add_user", methods={"GET", "POST"})
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

        if ($form->isSubmitted()){
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
            }
            else {
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

    /**
     * @param TranslatorInterface $translator
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN")
     * @Route("/declarer-perdue", name="card_lost", methods={"GET", "POST"})
     *
     */
    public function declareLostCard(TranslatorInterface $translator,
                                    Request $request,
                                    UserRepository $userRepository,
                                    CardRepository $cardRepository)
    {
        if (!$store = $this->getUser()->getStore()[0]) {
            throw new HttpException(401,
                $translator->trans('access.forbidden', [], 'messages'));
        }

        $message = "";
        $cards = [];
        $typeMessage = null;
        $labelButton = null;

        $form = $this->createForm('App\Form\LostTypeCard', null, [
            'store' => $store
        ]);

        $form->handleRequest($request);

        if (isset($request->request->get('lost_type_card')['customers'])
            && $request->request->get('lost_type_card')['customers'] !== null ) {
            $customerId = intval($request->request->get('lost_type_card')['customers']);
            $customer = $userRepository->findOneById(intval($customerId));
            $cards = $customer->getCards();
            $labelButton = 1;
        }

        if (isset($request->request->get('lost_type_card')['cards'])
            && $request->request->get('lost_type_card')['cards'] !== null ) {
            $cardId = $request->request->get('lost_type_card')['cards'];

            $card = $cardRepository->findOneById(intval($cardId));
            if (!$customer = $card->getUser()) {
                $message = $translator->trans('lost_card.inactive.error', [], 'forms');
                $typeMessage = "error";
            } else {
                $customer->removeCard($card);
                $message = $translator->trans('lost_card.inactive.success', [], 'forms');
                $typeMessage = "success";
            }

            //Workflow here, inactivating
        }

        if (!$request->isXmlHttpRequest() && $form->isSubmitted()) {
            $this->addFlash('success', $message);
            //todo voir où on envoie la redirection
            $this->redirectToRoute('home');
        }

        return $this->render('security/lost_card.html.twig', [
            'typeMessage' => $typeMessage,
            'message' => $message,
            'form' => $form->createView(),
            'cards' => $cards,
            'labelButton' => $labelButton
        ]);
    }
}