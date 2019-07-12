<?php

namespace App\Card;

use App\Entity\Card;
use App\Repository\CardRepository;

class CardGenerator
{
    private $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function generateCard(Card $card): Card
    {
        # Génération de la carte
        $card->setCustomerCode($this->generateCustomerCode())
            ->setCheckSum(($card->getStore()->getCenterCode() + $card->getCustomerCode()) % 9)
            ->setStatus(['PRE_ACTIVATED']);

        # Retour de la carte mise à jour
        return $card;
    }

    /**
     * Générer un code client aléatoire
     * @return int
     */
    public function generateCustomerCode(): int
    {
        $randCode = mt_rand(1,999999);

        $findSameCustomerCode = $this->cardRepository->findBy([
            'customerCode' => $randCode
        ]);

        if ($findSameCustomerCode) {
            $this->generateCustomerCode();
        }

        return intval(sprintf("%06s",$randCode));
    }

}