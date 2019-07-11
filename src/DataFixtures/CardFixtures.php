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
        for ($x = 1; $x < self::NB_CARDS; $x ++) {
            $card = new Card();
            $card->setStore($this->getReference('store_'.$x));
            $card->setUser($this->getReference('customer_'.$x));
            $card->setCustomerCode($this->cardGenerator->generateCustomerCode());
            $card->setCheckSum($faker->randomNumber(5));
            $card->setFidelityPoint(rand($x *10, $x * 100));

            $manager->persist($card);
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
            CustomerFixtures::class
        ];
    }

}