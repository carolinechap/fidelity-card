<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Repository\CardRepository;
use App\Repository\DealRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Deal\AddDealType;
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
     * @Route("/offre/{deal}", name="deal_add_card")
     * @ParamConverter("deal", options={"mapping": {"deal": "id"}})
     */
    public function addDeal(Deal $deal, CardRepository $cardRepository, Request $request, ObjectManager $objectManager, TranslatorInterface $translator)
    {
        $user = $this->getUser();

        if (!$card = $cardRepository->findCardByUser($user)) {
            $this->addFlash('danger', $translator->trans('deal.user.nocard', [], 'messages'));
            return $this->redirectToRoute('deal_display_user');
        }

        $card->addDeal($deal);

        $costPoint = $deal->getCostPoint();
        $fidelityPoint = $card->getFidelityPoint();
        $updatedFidelityPoint = $this->updatefidelityPoint($fidelityPoint, $costPoint);
        $card->setFidelityPoint($updatedFidelityPoint);

        $objectManager->persist($card);
        $objectManager->flush();

        $this->addFlash('success', $translator->trans('addeal.success', [], 'forms'));

        return $this->redirectToRoute('deal_display_user');
    }

    private function updatefidelityPoint($fidelityPoint, $dealCost)
    {
        return $fidelityPoint - $dealCost;
    }

    /**
     * @Route("/", name="deal_display_all")
     */
    public function displayDeals(DealRepository $dealRepository)
    {
        $deals = $dealRepository->findAll();

        return $this->render('superadmin/deal/index.html.twig', [
            'deals' => $deals
        ]);
    }

    /**
     * @Route("/client", name="deal_display_user")
     */
    public function displayUserDeals(CardRepository $cardRepository, DealRepository $dealRepository)
    {
        $user = $this->getUser();

        $card = $cardRepository->findCardByUser($user);
        $deals = $dealRepository->findBy([
            'card' => $card
        ]);

        return $this->render('superadmin/deal/index.html.twig', [
            'deals' => $deals
        ]);
    }

    /**
     * @Route("/{id}", name="deal_show", methods={"GET"})
     */
    public function show(Deal $deal): Response
    {
        return $this->render('superadmin/deal/show.html.twig', [
            'deal' => $deal,
        ]);
    }


}