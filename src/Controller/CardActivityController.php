<?php

namespace App\Controller;

use App\Activity\FidelityPointGenerator;
use App\Activity\SumPersonalScore;
use App\Entity\Activity;
use App\Entity\Card;
use App\Entity\CardActivity;
use App\Entity\User;
use App\Form\ActivityType;
use App\Form\CardActivityType;
use App\Repository\ActivityRepository;
use App\Repository\CardActivityRepository;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class CardActivityController
 * @package App\Controller
 * @Route("carte/activite")
 */
class CardActivityController extends AbstractController
{
    /**
     * @Route("/", name="card_activity_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(CardActivityRepository $cardActivityRepository,
                          ActivityRepository $activityRepository,
                          CardRepository $cardRepository,
                          UserRepository $userRepository)
    {
        $cardActivities = $cardActivityRepository->findAll();
        $activities = $activityRepository->findAll();
        $cards = $cardRepository->findAll();
        $users = $userRepository->findAll();


        return $this->render('admin/card_activity/index.html.twig', [
            'cardActivities' => $cardActivities,
            'activities' => $activities,
            'users' => $users,
            'cards' => $cards
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/creation", name="card_activity_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FidelityPointGenerator $fidelityPointGenerator, SumPersonalScore $sumPersonalScore): Response
    {
        $cardActivity = new CardActivity();

        $form = $this->createForm(CardActivityType::class, $cardActivity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Lorsque le client effectue une activité
            // Ajouter les points de fidélité sur la carte
            //TODO:Refactorer au niveau de cardController
            $fidelityPoint = $fidelityPointGenerator->sumFidelityPoint($cardActivity);
            $cardActivity->getCard()->setFidelityPoint($fidelityPoint);

            // Ajouter le score personnel sur la carte
            //TODO:Refactorer au niveau de cardController
            $personalScoreFromForm = $form->getData()->getPersonalScore();
            $personalScore = $sumPersonalScore->sumPersonalScore($cardActivity, $personalScoreFromForm);
            $cardActivity->getCard()->setPersonalScore($personalScore);


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($cardActivity);
            $entityManager->flush();

            return $this->redirectToRoute('card_activity_index');
        }

        return $this->render('admin/card_activity/new.html.twig', [
            'cardActivity' => $cardActivity,
            'form' => $form->createView()
        ]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/suppression/{id}", name="card_activity_delete", methods={"GET"})
     */
    public function delete(CardActivity $cardActivity) {

        $user = $cardActivity->getCard()->getUser()->getFullName();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cardActivity);
        $entityManager->flush();

        $this->addFlash('success', "L'activité de $user est supprimée");

        return $this->redirectToRoute('card_activity_index');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/historique", name="card_activity_historical", methods={"GET"})
     */
    public function displayHistorical(CardActivityRepository $cardActivityRepository, CardRepository $cardRepository){

        // Récupération de l'id du User
        $user = $this->getUser();

        $activities = $cardActivityRepository->findActivityByUser($user);
        //TODO:Recuperer seulement 1 fois sans boucle les points
        //$card = $cardRepository->findCardByUser($user);
        //dd($card);

        return $this->render('card_activity/historical.html.twig', [
            'activities' => $activities,
            //'card' => $card
        ]);

    }

}
