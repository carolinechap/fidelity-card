<?php


namespace App\Command;


use App\Activity\FidelityPointGenerator;
use App\Activity\CalculatePersonalScore;
use App\Entity\Activity;
use App\Entity\Card;
use App\Entity\CardActivity;
use App\Events\AppEvents;
use App\Events\CardActivityEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


/**
 * Class NewCardActivityCommand
 * @package App\Command
 */
class NewCardActivityCommand extends Command
{

    /**
     * @var string
     */
    protected static $defaultName = 'app:new-card-activity';

    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var FidelityPointGenerator
     */
    private $generator;
    /**
     * @var CalculatePersonalScore
     */
    private $calculatePersonalScore;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;


    /**
     * NewCardActivityCommand constructor.
     * @param EntityManagerInterface $manager
     * @param FidelityPointGenerator $fidelityPointGenerator
     * @param CalculatePersonalScore $calculatePersonalScore
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManagerInterface $manager,
                                FidelityPointGenerator $fidelityPointGenerator,
                                CalculatePersonalScore $calculatePersonalScore, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->generator = $fidelityPointGenerator;
        $this->calculatePersonalScore = $calculatePersonalScore;
        $this->eventDispatcher = $eventDispatcher;

    }

    protected function configure()
    {
        $this->setDescription('Generate a new random activity for an client');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // Set values into variables
        $activity = $this->getRandomActivity();
        $card = $this->getRandomCard();
        $isTheWinner = $this->getRandomWinnerGame();
        $randPersonalScore = $this->getRandomPersonalScore();

        // Generate an card/activity
        $oneCardActivity = new CardActivity();

        $oneCardActivity->setCard($card)
            ->setActivity($activity)
            ->setGameDate(new \DateTime())
            ->setIsTheWinner($isTheWinner)
            ->setPersonalScore($randPersonalScore);


        // Fidelity points on cardActivity and Card
        $beforePoints=  $oneCardActivity->getCard()->getFidelityPoint();
        $fidelityPoint = $this->generator->sumFidelityPoint($oneCardActivity);
        $oneCardActivity->getCard()->setFidelityPoint($fidelityPoint);

        // Personal score on cardActivity and Card
        $personalScoreSum = $this->calculatePersonalScore->sumPersonalScore($oneCardActivity, $randPersonalScore);

        // Set the total into Card
        $oneCardActivity->getCard()->setPersonalScore($personalScoreSum);

        //On déclenche l'événement' correspondant
        $event = new CardActivityEvent($oneCardActivity);
        $event->setBeforePoints($beforePoints);
        $this->eventDispatcher->dispatch($event, AppEvents::CARD_NEW_ACTIVITY);


        try {
            $this->manager->persist($oneCardActivity);
            $this->manager->flush();

            $io->success('Super, un client a effectué une activité dans le centre');
        } catch (LogicException $exception) {
            $io->warning($exception->getMessage());
            $io->error('Oups, il y a eu une erreur de process');
        }
    }

    /**
     * Get some random activities from database
     */
    private function getRandomActivity(): Activity
    {
        $activities = $this->manager->getRepository(Activity::class)->findAll();
        return $activities[array_rand($activities)];
    }

    /**
     * Get some random fidelityCard from database
     */
    private function getRandomCard(): Card
    {
        $cards = $this->manager->getRepository(Card::class)->findCardWithUser();
        return $cards[array_rand($cards)];
    }

    /**
     * Get some random personal score
     */
    private function getRandomPersonalScore()
    {
        $personalScores = [
            15,
            65,
            40,
            30,
            75,
            99,
            25,
            35
        ];
        return $personalScores[array_rand($personalScores)];
    }

    /**
     * Get some random winner
     */
    private function getRandomWinnerGame()
    {
        $isTheWinner = [
            1,
            0
        ];
        return $isTheWinner[array_rand($isTheWinner)];
    }

}