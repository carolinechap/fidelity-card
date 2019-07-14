<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActivityFixtures extends Fixture
{
    const COUNT = 10;

    private function getActivityName()
    {
        $activityName = [
            'Duo',
            'Battle',
            'Battle royal',
            'Course contre la montre',
            'Match à mort par équipe',
        ];
        $randActivityName = $activityName[array_rand($activityName)];
        return $randActivityName;
    }

    public function load(ObjectManager $manager)
    {

        for($a = 0; $a<self::COUNT; $a++){
            $fidelityPoint = $a + rand($a, 200);
            $activity = new Activity();
            $activity->setGameName($this->getActivityName());
            $activity->setFidelityPoint($fidelityPoint);

            $manager->persist($activity);
        }
        $manager->flush();
    }
}
