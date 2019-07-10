<?php


namespace App\Activity;


use App\Entity\CardActivity;

class SumPersonalScore
{


    public function sumPersonalScore(CardActivity $cardActivity, $gamePersonalScore) : int
    {
        $PersonalScoreOnCard = $cardActivity->getCard()->getPersonalScore();

            $result = $PersonalScoreOnCard + $gamePersonalScore;

            return $result;

    }

}