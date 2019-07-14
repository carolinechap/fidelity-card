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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response
     * @Route("/", name="deal_display_all")
     */
    public function displayAllDeals()
    {
        $cards = $this->getUserCards();
        $deals = $this->dealRepository->findAll();

        return $this->render('deal/deals_with_cards.html.twig', [
            'deals' => $deals,
            'cards' => $cards
        ]);
    }

    /**
     * @Route("/offre/{deal}", name="deal_add_card", methods={"GET", "POST"})
     * @ParamConverter("deal", options={"mapping": {"deal": "id"}})
     */
    public function addDeal(Deal $deal, Request $request)
    {
            $cards = $this->getUserCards();

            if ($card = $this->checkIfOnlyOneCard($cards, $deal)) {
                return $this->redirectToRoute('deal_display_card', [
                    'card' => $card->getId()
                ]);
            }

            if ($request->isMethod("POST")) {
                $cardId = $request->request->get('cards');
                $card = $this->cardRepository->find($cardId);

                $this->addMyDeal($card, $deal);
                return $this->redirectToRoute('deal_display_card', [
                    'card' => $card->getId()
                ]);
            } else {
                return $this->render('deal/choice_card.html.twig', [
                    'cards' => $cards,
                    'deal' => $deal
                ]);
            }
    }

    /**
     * @Route("/client/{id}", name="deal_display_user", methods={"GET"})
     */
    public function displayDeals(User $user)
    {
        $cards = $this->cardRepository->findCardByUser($user);

        foreach ($cards as $card) {
            $deals[] = $card->getDeals();
        }

        return $this->render('deal/deals_with_cards.html.twig', [
            'deals' => $deals[0],
            'cards' => $cards
        ]);
    }

    /**
     * @Route("/client/card/{card}", name="deal_display_card", methods={"GET"})
     * @ParamConverter("card", options={"mapping": {"card": "id"}})
     */
    public function displayCardDeals(Card $card)
    {
        $deals = $card->getDeals();

        return $this->render('deal/deals_with_cards.html.twig', [
            'deals' => $deals,
            'card' => $card
        ]);
    }

    /**
     * @Route("/{id}", name="deal_show", methods={"GET"})
     */
    public function show(Deal $deal): Response
    {
        return $this->render('deal/show.html.twig', [
            'deal' => $deal,
        ]);
    }

    private function checkIfOnlyOneCard($cards, Deal $deal):Card {
        if (count($cards) === 1){
            $card = $cards[0];
            $this->addMyDeal($card, $deal);
            return $card;
        }
        return null;
    }

    private function addMyDeal(Card $card, Deal $deal) {
        $costPoint = $deal->getCostPoint();
        $fidelityPoint = $card->getFidelityPoint();
        if ( $fidelityPoint >= $costPoint ) {
            $updatedFidelityPoint = $this->updatefidelityPoint($fidelityPoint, $costPoint);

            $card->addDeal($deal);
            $card->setFidelityPoint($updatedFidelityPoint);

            $this->objectManager->flush();
            $this->addFlash('success', $this->translator->trans('addeal.success', [], 'forms'));
        } else {
            $this->addFlash('error', $this->translator->trans('addeal.error', [], 'forms'));
        }
    }

    private function updatefidelityPoint($fidelityPoint, $dealCost){
        return $fidelityPoint - $dealCost < 0 ? 0 : $fidelityPoint - $dealCost;
    }

    private function getUserCards(){
        $user = $this->getUser();

        if (!$cards = $this->cardRepository->findBy(['user' => $user])) {
            $this->addFlash('danger', $this->translator->trans('deal.user.nocard', [], 'messages'));

            return $this->redirectToRoute('deal_display_user');
        }
        return $cards;
    }
}