<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Store;

class StoreFixtures extends Fixture implements DependentFixtureInterface
{

    const NB_STORES = 5;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($x = 1; $x < self::NB_STORES; $x ++)
        {
            $store = new Store();
            $store->setName("LaserGame ".$faker->lastName);
            for ($y = 1; $y < CustomerFixtures::COUNT; $y ++) {
                $store->addUser($this->getReference('customer_'.$y));
            }

        }
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