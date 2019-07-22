<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ActivityFixtures
 * @package App\DataFixtures
 */
class ActivityFixtures extends Fixture
{
    /**
     *
     */
    const COUNT = 10;

    /**
     * @return mixed
     */
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

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Demo and test purposes
        $oneActivity = new Activity();
        $oneActivity->setFidelityPoint(100);
        $oneActivity->setGameName('ActivityTest');
        $this->addReference('myactivity', $oneActivity);

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
