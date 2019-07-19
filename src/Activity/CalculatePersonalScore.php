<?php


namespace App\Activity;


use App\Entity\CardActivity;

class CalculatePersonalScore
{


    public function sumPersonalScore(CardActivity $cardActivity, $gamePersonalScore) : int
    {
        $PersonalScoreOnCard = $cardActivity->getCard()->getPersonalScore();

            $result = $PersonalScoreOnCard + $gamePersonalScore;

            return $result;

    }

    public function subPersonalScore(CardActivity $cardActivity, $gamePersonalScore) : int
    {
        $PersonalScoreOnCard = $cardActivity->getCard()->getPersonalScore();

        $result = $PersonalScoreOnCard - $gamePersonalScore;

        return $result;

    }

}