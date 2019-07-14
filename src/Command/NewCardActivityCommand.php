<?php


namespace App\Command;


use App\Entity\Activity;
use App\Entity\Card;
use App\Entity\CardActivity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewCardActivityCommand extends Command
{

    protected static $defaultName = 'newCardActivity';

    private $manager;

    const COUNT = 30;

    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }
    protected function configure()
    {
        $this->setDescription('Generate a new random activity for an client');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // On va chercher les informations
        $activity = $this->getRandomActivity();
        $card = $this->getRandomCard();
        $isTheWinner = $this->getRandomWinnerGame();
        $personalScore = $this->getRandomPersonalScore();

        // Generation de l'activité/client
        $cardActivity = new CardActivity();

        for($a = 0; $a<self::COUNT; $a++) {
            $cardActivity->setCard($card)
                ->setActivity($activity)
                ->setGameDate(new \DateTime())
                ->setIsTheWinner($isTheWinner)
                ->setPersonalScore($personalScore);
        }
            try {
                $this->manager->persist($cardActivity);
                $this->manager->flush();
                $io->success('Super, des clients sont venus jouer dans votre centre');
            } catch (LogicException $exception) {
                $io->warning($exception->getMessage());
                $io->error('Oups, il y a eu une erreur de process ');
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
        $cards = $this->manager->getRepository(Card::class)->findAll();
         return $cards[array_rand($cards)];
    }

    /**
     * Get some random personal score
     */
    private function getRandomPersonalScore()
    {
        $personalScores = [
            15,
            189,
            43,
            26,
            78,
            99,
            26,
            38
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