<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Deal;

class DealFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("fr_FR");
        $now = new \DateTime('now');
        $later =  null;

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
