<?php

namespace App\Controller;

use App\Card\CardGenerator;
use App\Card\CardNumberExtractor;
use App\Form\AddCardType;
use App\Form\CardType;
use App\Repository\CardRepository;
use App\Entity\Card;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Workflow\Registry;

/**
 * Class CardController
 * @package App\Controller
 * @Route("/carte")
 */
class CardController extends AbstractController
{
    /**
     * @var Registry
     */
    private $registry;

    private $entityManager;

    /**
     * CardController constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry, EntityManagerInterface $entityManager)
    {
        $this->registry = $registry;
        $this->entityManager = $entityManager;
    }

    /**
     * @param CardRepository $cardRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="card_index")
     */
    public function index(
        CardRepository $cardRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
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

            # Handle workflow
            $this->updateWorkflow($card, 'to_creating');

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
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     *
     * @Route("/suppression/{id}", name="card_delete")
     */
    public function delete(Card $card, TranslatorInterface $translator): RedirectResponse
    {
        $this->entityManager->remove($card);
        $this->entityManager->flush();

        $this->addFlash('success', $translator->trans('card.remove.success', [], 'forms'));

        return $this->redirectToRoute('card_index');
    }

    /**
     * @param Request $request
     * @param CardRepository $cardRepository
     * @param TranslatorInterface $translator
     * @param CardNumberExtractor $cardNumberExtractor
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     * @Route("/ajouter-client", name="card_add_user", methods={"GET", "POST"})
     */
    public function addCardToUser(Request $request,
                                  CardRepository $cardRepository,
                                  TranslatorInterface $translator,
                                  CardNumberExtractor $cardNumberExtractor): Response
    {
        if (!$user = $this->getUser()) {
            throw new UnauthorizedHttpException($translator->trans('access.forbidden', [], 'messages'));
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

                # Handle Workflow
                $this->updateWorkflow($card, 'to_activating');

                $this->entityManager->flush();
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
     * @param CardRepository $cardRepository
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN")
     * @Route("/declarer-perdue", name="card_lost", methods={"GET", "POST"})
     */
    public function declareLostCard(TranslatorInterface $translator,
                                    Request $request,
                                    UserRepository $userRepository,
                                    CardRepository $cardRepository): Response
    {
        if (!$store = $userRepository->findStoreForEmployee($this->getUser())) {
            throw new HttpException(403,
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
                # Handle Workflow
                $this->updateWorkflow($card, 'to_deactivating');

                $this->entityManager->flush();
                $message = $translator->trans('lost_card.inactive.success', [], 'forms');
                $typeMessage = "success";

            }
        }

        if (!$request->isXmlHttpRequest() && $form->isSubmitted()) {
            $this->addFlash('success', $message);
            //Redirect to admin dashboard
            $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('security/lost_card.html.twig', [
            'typeMessage' => $typeMessage,
            'message' => $message,
            'form' => $form->createView(),
            'cards' => $cards,
            'labelButton' => $labelButton
        ]);
    }

    /**
     * @param $card
     * @param $status
     */
    private function updateWorkflow($card, $status)
    {
        # Handle Workflow
        $workflow = $this->registry->get($card);
        if ($workflow->can($card, $status)) {
            try {
                $workflow->apply($card, $status);
            } catch (LogicException $e) {
                # Transition non autorisé
                $e->getMessage();
            }
        }
    }
}