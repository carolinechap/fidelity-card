<?php


namespace App\Activity;


use App\Entity\CardActivity;

class CalculatePersonalScore
{

    /**
     * Search personal score on user's card and add the personal score from the current activity with the one on card.
     *
     * @param CardActivity $cardActivity
     * @param $gamePersonalScore
     * @return int
     */
    public function sumPersonalScore(CardActivity $cardActivity, $gamePersonalScore): int
    {
        $PersonalScoreOnCard = $cardActivity->getCard()->getPersonalScore();

        $result = $PersonalScoreOnCard + $gamePersonalScore;

        return $result;

    }

    /**
     * Search personal score on user's card and subtract the personal score on card with the one of the current.
     *
     * @param CardActivity $cardActivity
     * @param $gamePersonalScore
     * @return int
     */
    public function subPersonalScore(CardActivity $cardActivity, $gamePersonalScore): int
    {
        $PersonalScoreOnCard = $cardActivity->getCard()->getPersonalScore();

        $result = $PersonalScoreOnCard - $gamePersonalScore;

        return $result;

    }

}