<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Deal;

/**
 * Class DealFixtures
 * @package App\DataFixtures
 */
class DealFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        $now = new \DateTime('2019/07/30');
        $later =  null;


        // This deal is for test and demo purposes
        $oneDeal = new Deal();
        $oneDeal->setName('OffreTest');
        $oneDeal->setDescription('Offre anniversaire');
        $oneDeal->setStartDate($now);
        $oneDeal->setEndDate($now);
        $oneDeal->setCostPoint(50);

        $manager->persist($oneDeal);

        $now = new \DateTime('now');

        for ($x = 0; $x < 7; $x ++) {
            $costPoint = $x + rand($x, 200);
            $deal = new Deal();

            $later = $now->modify('+'.$x. ' days');
            $deal->setName($faker->sentence);
            $deal->setDescription($faker->text);
            $deal->setStartDate($now);
            $deal->setEndDate($later);
            $deal->setCostPoint($costPoint);

            $manager->persist($deal);
            $this->addReference('deal_'. $x, $deal);
        }

        $manager->flush();
    }
}
