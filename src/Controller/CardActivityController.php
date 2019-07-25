<?php

namespace App\Controller;

use App\Activity\FidelityPointGenerator;
use App\Activity\CalculatePersonalScore;
use App\Entity\CardActivity;
use App\Events\AppEvents;
use App\Events\CardActivityEvent;
use App\Form\CardActivityType;
use App\Repository\ActivityRepository;
use App\Repository\CardActivityRepository;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CardActivityController
 * @package App\Controller
 * @Route("/dashboards/carte/activite")
 */
class CardActivityController extends AbstractController
{
    /**
     * @Route("/", name="card_activity_index")
     * @IsGranted("ROLE_ADMIN")
     *
     * @param CardActivityRepository $cardActivityRepository
     * @param ActivityRepository $activityRepository
     * @param CardRepository $cardRepository
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(CardActivityRepository $cardActivityRepository,
                          ActivityRepository $activityRepository,
                          CardRepository $cardRepository,
                          UserRepository $userRepository,
                          PaginatorInterface $paginator,
                          Request $request)
    {
        $cardActivities = $paginator->paginate($cardActivityRepository->findByGameDate(), $request->query->getInt('page', 1), 5);
        $activities = $activityRepository->findAll();
        $cards = $cardRepository->findAll();
        $users = $userRepository->findAll();

        $lastRec = $cardActivityRepository->findLastRecord();


        return $this->render('admin/card_activity/index.html.twig', [
            'cardActivities' => $cardActivities,
            'activities' => $activities,
            'users' => $users,
            'cards' => $cards,
            'last_record' => $lastRec
        ]);
    }

    /**
     * @param Request $request
     * @param FidelityPointGenerator $fidelityPointGenerator
     * @param CalculatePersonalScore $calculatePersonalScore
     * @param TranslatorInterface $translator
     * @param EventDispatcherInterface $eventDispatcher
     * @return Response
     *
     * @Route("/creation", name="card_activity_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request,
                        FidelityPointGenerator $fidelityPointGenerator,
                        CalculatePersonalScore $calculatePersonalScore,
                        TranslatorInterface $translator,
                        EventDispatcherInterface $eventDispatcher): Response
    {
        $cardActivity = new CardActivity();

        $form = $this->createForm(CardActivityType::class, $cardActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // When a client plays a game
                // Add fidelity points on his card
                $beforePoints = $cardActivity->getCard()->getFidelityPoint();
                $fidelityPoint = $fidelityPointGenerator->sumFidelityPoint($cardActivity);
                $cardActivity->getCard()->setFidelityPoint($fidelityPoint);

                // Add personal score on his card
                $personalScoreFromForm = $form->getData()->getPersonalScore();
                $personalScore = $calculatePersonalScore->sumPersonalScore($cardActivity, $personalScoreFromForm);
                $cardActivity->getCard()->setPersonalScore($personalScore);

                $entityManager = $this->getDoctrine()->getManager();

                $entityManager->persist($cardActivity);
                $entityManager->flush();

                //Trigger the corresponding event
                $event = new CardActivityEvent($cardActivity);
                $event->setBeforePoints($beforePoints);
                $eventDispatcher->dispatch($event, AppEvents::CARD_NEW_ACTIVITY);

                $this->addFlash('success', $translator->trans('new.success', [], 'crud'));

                return $this->redirectToRoute('card_activity_index');
            } else {
                $this->addFlash('error', $translator->trans('new.error', [], 'crud'));

            }
        }

        return $this->render('admin/card_activity/new.html.twig', [
            'cardActivity' => $cardActivity,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/suppression/{id}", name="card_activity_delete", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     * @param CardActivity $cardActivity
     * @param TranslatorInterface $translator
     * @param CalculatePersonalScore $calculatePersonalScore
     * @param FidelityPointGenerator $fidelityPointGenerator
     * @return RedirectResponse
     */
    public function delete(CardActivity $cardActivity,
                           TranslatorInterface $translator,
                           CalculatePersonalScore $calculatePersonalScore,
                           FidelityPointGenerator $fidelityPointGenerator)
    {

        // Remove personal score of this activity from card
        $activityPersonalScore = $cardActivity->getPersonalScore();
        $personalScore = $calculatePersonalScore->subPersonalScore($cardActivity, $activityPersonalScore);
        $cardActivity->getCard()->setPersonalScore($personalScore);

        // Remove fidelity points of this activity from card
        $fidelityPoints = $fidelityPointGenerator->subFidelityPoint($cardActivity);
        $cardActivity->getCard()->setFidelityPoint($fidelityPoints);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cardActivity);
        $entityManager->flush();

        $this->addFlash('success', $translator->trans('remove.success', [], 'crud'));

        return $this->redirectToRoute('card_activity_index');
    }

    /**
     * Personal profile, allows to display historical activities, personal scores and fidelity points per card.
     * @Route("/historique", name="card_activity_historical", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @param CardActivityRepository $cardActivityRepository
     * @param CardRepository $cardRepository
     * @return Response
     */
    public function displayHistorical(CardActivityRepository $cardActivityRepository,
                                      CardRepository $cardRepository)
    {

        // Find user's id
        $user = $this->getUser();

        // Find user's activities
        $activities = $cardActivityRepository->findActivityByUser($user);

        // Find user's cards
        $cards = $cardRepository->findCardByUser($user);

        return $this->render('card_activity/historical.html.twig', [
            'activities' => $activities,
            'cards' => $cards
        ]);

    }

}
