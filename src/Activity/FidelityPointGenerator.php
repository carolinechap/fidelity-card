<?php


namespace App\Activity;


use App\Entity\CardActivity;

class FidelityPointGenerator
{

    public function generateFidelityPoint(CardActivity $cardActivity): int
    {

        if ($cardActivity->getIsTheWinner() == 1) {
            $cardActivity->getCard()->setFidelityPoint($cardActivity->getActivity()->getFidelityPoint() + 50);

        }
        if ($cardActivity->getIsTheWinner() == 0) {
            $cardActivity->getCard()->setFidelityPoint($cardActivity->getActivity()->getFidelityPoint());
        }
        return $cardActivity->getCard()->getFidelityPoint();
    }

    public function sumFidelityPoint(CardActivity $cardActivity): int
    {
        $fidelityPointOnCard = $cardActivity->getCard()->getFidelityPoint();

        $result = $fidelityPointOnCard + $this->generateFidelityPoint($cardActivity);

        return $result;

    }

    public function subFidelityPoint(CardActivity $cardActivity): int
    {
        $fidelityPointOnCard = $cardActivity->getCard()->getFidelityPoint();

        $activityFidelityPoint = $cardActivity->getActivity()->getFidelityPoint();

        if ($cardActivity->getIsTheWinner() == 1) {
            $result = $fidelityPointOnCard - ($activityFidelityPoint - 50);
        } else {
            $result = $fidelityPointOnCard - $activityFidelityPoint;
        }

        return $result;

    }
}