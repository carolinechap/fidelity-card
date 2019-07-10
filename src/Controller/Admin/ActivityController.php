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

/**
 * Class ActivityController
 * @package App\Controller
 * @Route("/admin/activite")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="activity_index", methods={"GET"})
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
     */
    public function new(Request $request, FidelityPointGenerator $fidelityPointGenerator): Response
    {
        $activity = new Activity();

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //$activity = $fidelityPointGenerator->generateFidelityPoint($activity);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('activity_index');
        }

        return $this->render('admin/activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}/edition", name="activity_edit", methods={"GET","POST"})
     *
     */
    public function edit(Request $request, Activity $activity, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();

            return $this->redirectToRoute('activity_index', [
                'id' => $activity->getId()
            ]);
        }

        return $this->render('admin/activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}", name="activity_delete", methods={"GET"})
     */
    public function delete(EntityManagerInterface $entityManager, Activity $activity) : Response
    {
        $entityManager->remove($activity);
        $entityManager->flush();

        $this->addFlash('success', "L'activité a été supprimée");

        return $this->redirectToRoute('activity_index');
    }

}
