<?php


namespace App\Activity;


use App\Entity\Activity;

class FidelityPointGenerator
{

    public function generateFidelityPoint(Activity $activity) : Activity
    {

        if($activity->getIsTheWinner() == 1){

            $activity->setFidelityPoint(150);
        }
        if ($activity->getIsTheWinner() == 0){
            $activity->setFidelityPoint(50);
        }
        return $activity;
    }

}