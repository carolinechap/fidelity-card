<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Deal;
use App\Entity\User;
use App\Repository\CardRepository;
use App\Repository\DealRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class DealController
 * @package App\Controller
 *
 * @IsGranted("ROLE_USER")
 * @Route("/offres")
 */
class DealController extends AbstractController
{

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var CardRepository
     */
    private $cardRepository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var DealRepository
     */
    private $dealRepository;


    /**
     * DealController constructor.
     * @param TranslatorInterface $translator
     * @param CardRepository $cardRepository
     * @param ObjectManager $objectManager
     * @param DealRepository $dealRepository
     */
    public function __construct(TranslatorInterface $translator,
                                CardRepository $cardRepository,
                                ObjectManager $objectManager,
                                DealRepository $dealRepository)
    {
        $this->translator = $translator;
        $this->cardRepository = $cardRepository;
        $this->objectManager = $objectManager;
        $this->dealRepository = $dealRepository;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="deal_display_all", methods={"GET", "POST"})
     */
    public function displayAllDeals(Request $request)
    {
        $card = null;
        $cards = $this->getUserCards();

        if ($request->request->get('cards') !== 'null' && $request->request->get('cards') !== null) {
            $card = $this->cardRepository->find($request->request->get('cards'));
            if ($this->getUser()->getEmail() !== $card->getUser()->getEmail()) {
                throw new UnauthorizedHttpException("Vous n'êtes pas autorisé à effectuer cette action.");
            }
        }

        $deals = $this->dealRepository->findAll();

        return $this->render('deal/all_deals_list.html.twig', [
            'deals' => $deals,
            'cards' => $cards,
            'card' => $card
        ]);
    }

    /**
     * @param Deal $deal
     * @param Card $card
     * @return RedirectResponse
     *
     * @Route("/offre/{deal}/{card}", name="deal_add_card", methods={"GET"})
     * @ParamConverter("deal", options={"mapping": {"deal": "id"}})
     * @ParamConverter("card", options={"mapping": {"card": "id"}})
     */
    public function addDeal(Deal $deal, Card $card)
    {
        $costPoint = $deal->getCostPoint();
        $fidelityPoint = $card->getFidelityPoint();

        if ($fidelityPoint >= $costPoint) {
            $updatedFidelityPoint = $this->updatefidelityPoint($fidelityPoint, $costPoint);

            $card->addDeal($deal);
            $card->setFidelityPoint($updatedFidelityPoint);

            $this->objectManager->flush();
            $this->addFlash('success', $this->translator->trans('add_deal.success', [], 'messages'));
        } else {
            $this->addFlash('error', $this->translator->trans('add_deal.error', [], 'messages'));
        }

        return $this->redirectToRoute('deal_display_all');
    }

    /**
     * @return Response
     *
     * @Route("/client", name="deal_display_user", methods={"GET"})
     */
    public function displayDeals()
    {
        $user = $this->getUser();
        $cards = $this->cardRepository->findCardByUser($user);

        return $this->render('deal/user_deals_list.html.twig', [
            'cards' => $cards
        ]);
    }

    /**
     * @param Deal $deal
     * @return Response
     *
     * @Route("/{id}", name="deal_show", methods={"GET"})
     */
    public function show(Deal $deal): Response
    {
        return $this->render('deal/show.html.twig', [
            'deal' => $deal,
        ]);
    }

    /**
     * @param $fidelityPoint
     * @param $dealCost
     * @return int
     */
    private function updatefidelityPoint($fidelityPoint, $dealCost)
    {
        return $fidelityPoint - $dealCost < 0 ? 0 : $fidelityPoint - $dealCost;
    }

    /**
     * @return Card[]
     */
    private function getUserCards()
    {
        $user = $this->getUser();
        $cards = $this->cardRepository->findBy(['user' => $user]);

        return $cards;
    }
}