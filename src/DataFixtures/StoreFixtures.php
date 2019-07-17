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

        //This store is for test and demo purposes
        $myStore = new Store();
        $myStore->setName('LaserGame myStore');
        $myStore->setCenterCode($faker->numberBetween(100, 999));
        $myStore->setCity($faker->city);
        $myStore->setCountry($faker->country);
        $myStore->setNumberStreet($faker->numberBetween(1,30));
        $myStore->setNameStreet($faker->streetName);
        $myStore->setZipCode($faker->postcode);
        $manager->persist($myStore);
        $this->addReference('mystore', $myStore);

        for ($x = 1; $x < self::NB_STORES + 1; $x ++)
        {
            $store = new Store();
            $store->setName("LaserGame ".$faker->lastName);
            for ($y = 1; $y < CustomerFixtures::COUNT; $y ++) {
                $store->addUser($this->getReference('customer_'.$y));
            }
            $store->setCenterCode($faker->numberBetween(100, 999));
            $store->setCity($faker->city);
            $store->setCountry('France');
            $store->setNumberStreet($faker->numberBetween(1,30));
            $store->setNameStreet($faker->streetName);
            $store->setZipCode($faker->postcode);
            $manager->persist($store);
            $this->addReference('store_'.$x, $store);
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