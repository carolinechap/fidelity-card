<?php


namespace App\DataFixtures;


use App\Card\CardGenerator;
use App\Entity\Card;
use App\Repository\CardRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

/**
 * Class CardFixtures
 * @package App\DataFixtures
 */
class CardFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     *
     */
    const NB_CARDS = 12;

    /**
     * @var CardRepository
     */
    private $cardRepository;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * CardFixtures constructor.
     * @param CardRepository $cardRepository
     * @param CardGenerator $cardGenerator
     * @param Registry $registry
     */
    public function __construct(CardRepository $cardRepository,
                                CardGenerator $cardGenerator,
                                Registry $registry)
    {
        $this->cardRepository = $cardRepository;
        $this->cardGenerator = $cardGenerator;
        $this->registry = $registry;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        # This card is for test and demo purposes
        $oneCard = new Card();
        $oneCard->setUser($this->getReference('customer1'));
        $oneCard->setFidelityPoint(500);
        $oneCard->setStore($this->getReference('mystore'));
        $oneCard = $this->cardGenerator->generateCard($oneCard);

        # Handle Workflow
        $this->updateWorkflow($oneCard, 'to_creating');

        $manager->persist($oneCard);

        # This card is for test and demo purposes
        $secondCard = new Card();
        $secondCard->setUser($this->getReference('customer1'));
        $secondCard->setFidelityPoint(300);
        $secondCard->setStore($this->getReference('store_1'));
        $secondCard = $this->cardGenerator->generateCard($secondCard);

        # Handle Workflow
        $this->updateWorkflow($secondCard, 'to_creating');

        $manager->persist($secondCard);

        # Cartes reliées à des comptes
        for ($x = 1; $x < self::NB_CARDS; $x ++) {
            $card = new Card();
            for ($y = 1; $y <= StoreFixtures::NB_STORES-1; $y ++) {
                $card->setStore($this->getReference('store_'. rand($y, StoreFixtures::NB_STORES-1)));
            }
            $card->setUser($this->getReference('customer_'.$x));
            $card = $this->cardGenerator->generateCard($card);

            # Handle Workflow
            $this->updateWorkflow($card, 'to_creating');

            $card->setFidelityPoint(0);
            $manager->persist($card);
            $this->addReference('card_'.$x, $card);
        }

        # Cartes non reliées à des comptes
        for ($y = self::NB_CARDS; $y < (self::NB_CARDS * 2); $y ++) {
            $card = new Card();
            $card->setStore($this->getReference('store_'. rand(1, StoreFixtures::NB_STORES-1)));
            $card = $this->cardGenerator->generateCard($card);

            # Handle Workflow
            $this->updateWorkflow($card, 'to_creating');

            $card->setFidelityPoint(0);
            $manager->persist($card);
            $this->addReference('card_'.$y, $card);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            CustomerFixtures::class,
            StoreFixtures::class
        ];
    }

    /**
     * @param $card
     * @param $status
     */
    private function updateWorkflow($card, $status)
    {
        # Handle Workflow
        $workflow = $this->registry->get($card);
        if ($workflow->can($card, $status)) {
            try {
                $workflow->apply($card, $status);
            } catch (LogicException $e) {
                # Transition non autorisé
                $e->getMessage();
            }
        }
    }
}