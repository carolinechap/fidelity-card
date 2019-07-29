<?php


namespace App\Activity;


use App\Entity\CardActivity;

class FidelityPointGenerator
{

    CONST BONUS_POINT = 50;

    /**
     * Set fidelity points into the card depending of the result of the activity
     *
     * @param CardActivity $cardActivity
     * @return int
     */
    public function generateFidelityPoint(CardActivity $cardActivity): int
    {

        if ($cardActivity->getIsTheWinner() == 1) {
            $cardActivity->getCard()->setFidelityPoint($cardActivity->getActivity()->getFidelityPoint() + self::BONUS_POINT);

        }
        if ($cardActivity->getIsTheWinner() == 0) {
            $cardActivity->getCard()->setFidelityPoint($cardActivity->getActivity()->getFidelityPoint());
        }
        return $cardActivity->getCard()->getFidelityPoint();
    }

    /**
     * Search fidelity points on user's card and add fidelity points from the current activity with the one on card.
     *
     * @param CardActivity $cardActivity
     * @return int
     */
    public function sumFidelityPoint(CardActivity $cardActivity): int
    {
        $fidelityPointOnCard = $cardActivity->getCard()->getFidelityPoint();

        $result = $fidelityPointOnCard + $this->generateFidelityPoint($cardActivity);

        return $result;

    }

    /**
     * Search fidelity points on user's card and substract fidelity points from the current activity with the one on card.
     *
     * @param CardActivity $cardActivity
     * @return int
     */
    public function subFidelityPoint(CardActivity $cardActivity): int
    {
        $fidelityPointOnCard = $cardActivity->getCard()->getFidelityPoint();

        $activityFidelityPoint = $cardActivity->getActivity()->getFidelityPoint();

        if ($cardActivity->getIsTheWinner() == 1) {
            $result = $fidelityPointOnCard - ($activityFidelityPoint - self::BONUS_POINT);
        } else {
            $result = $fidelityPointOnCard - $activityFidelityPoint;
        }

        return $result;

    }
}