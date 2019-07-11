<?php

namespace App\Controller\SuperAdmin;

use App\Entity\Deal;
use App\Form\DealType;
use App\Repository\DealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gerant/offre")
 */
class DealController extends AbstractController
{
    /**
     * @Route("/", name="deal_index", methods={"GET"})
     */
    public function index(DealRepository $dealRepository): Response
    {
        return $this->render('superadmin/deal/index.html.twig', [
            'deals' => $dealRepository->findAll(),
        ]);
    }

    /**
     * @Route("/creation", name="deal_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $deal = new Deal();
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($deal);
            $entityManager->flush();

            return $this->redirectToRoute('deal_index');
        }

        return $this->render('superadmin/deal/new.html.twig', [
            'deal' => $deal,
            'form' => $form->createView(),
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

    /**
     * @Route("/{id}/edition", name="deal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Deal $deal): Response
    {
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('deal_index', [
                'id' => $deal->getId(),
            ]);
        }

        return $this->render('superadmin/deal/new.html.twig', [
            'deal' => $deal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/suppression/{id}", name="deal_delete", methods={"GET"})
     */
    public function delete(Deal $deal): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($deal);
            $entityManager->flush();
            $this->addFlash('success', 'L\'offre a été supprimée');

        return $this->redirectToRoute('deal_index');
    }
}
