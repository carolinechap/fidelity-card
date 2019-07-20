<?php

namespace App\Controller\Admin;

use App\Activity\FidelityPointGenerator;
use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ActivityController
 * @package App\Controller
 * @Route("/admin/activite")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="activity_index", methods={"GET"})
     * @param ActivityRepository $activityRepository
     * @return Response
     */
    public function index(ActivityRepository $activityRepository)
    {
        $activities = $activityRepository->findAll();

        return $this->render('admin/activity/index.html.twig', [
            'activities' => $activities,
        ]);
    }

    /**
     * @Route("/creation", name="activity_new", methods={"GET", "POST"})
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function new(Request $request,
                        TranslatorInterface $translator): Response
    {
        $activity = new Activity();

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();
            $this->addFlash('success', $translator->trans('add_activity.success', [], 'messages'));

            return $this->redirectToRoute('activity_index');

        } else {
            $this->addFlash('error', $translator->trans('add_activity.error', [], 'messages'));
        }

        return $this->render('admin/activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}/edition", name="activity_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Activity $activity
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function edit(Request $request,
                         Activity $activity,
                         EntityManagerInterface $entityManager,
                         TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', $translator->trans('add_activity.success', [], 'messages'));

            return $this->redirectToRoute('activity_index', [
                'id' => $activity->getId()
            ]);
        } else {
            $this->addFlash('error', $translator->trans('add_activity.error', [], 'messages'));
        }

        return $this->render('admin/activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}", name="activity_delete", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @param Activity $activity
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function delete(EntityManagerInterface $entityManager,
                           Activity $activity, TranslatorInterface $translator): Response
    {
        $entityManager->remove($activity);
        $entityManager->flush();

        $this->addFlash('success', $translator->trans('add_activity.delete', [], 'messages'));

        return $this->redirectToRoute('activity_index');
    }

}
