<?php


namespace App\DataFixtures;


use App\Card\CardGenerator;
use App\Entity\Card;
use App\Repository\CardRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CardFixtures extends Fixture implements DependentFixtureInterface
{
    const NB_CARDS = 12;

    private $cardRepository;

    public function __construct(CardRepository $cardRepository, CardGenerator $cardGenerator)
    {
        $this->cardRepository = $cardRepository;
        $this->cardGenerator = $cardGenerator;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //This card is for test and demo purposes
        $oneCard = new Card();
        $oneCard->setUser($this->getReference('mycustomer'));
        $oneCard->setCustomerCode($this->cardGenerator->generateCustomerCode());
        $oneCard->setCheckSum($faker->randomNumber(5));
        $oneCard->setFidelityPoint($faker->numberBetween(200, 500));
        $oneCard->setStore($this->getReference('mystore'));
        
        $manager->persist($oneCard);

        for ($x = 1; $x < self::NB_CARDS; $x ++) {
            $card = new Card();
            for ($y = 1; $y <= StoreFixtures::NB_STORES; $y ++) {
                $card->setStore($this->getReference('store_'.$y));
            }
            $card->setUser($this->getReference('customer_'.$x));
            $card->setCustomerCode($this->cardGenerator->generateCustomerCode());
            $card->setCheckSum($faker->randomNumber(5));
            $card->setFidelityPoint($faker->numberBetween(200, 500));

            $manager->persist($card);
            $this->addReference('card_'.$x, $card);
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

}