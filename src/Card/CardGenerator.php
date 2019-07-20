<?php

namespace App\Card;

use App\Entity\Card;
use App\Repository\CardRepository;

/**
 * Class CardGenerator
 * @package App\Card
 */
class CardGenerator
{
    /**
     * @var CardRepository
     */
    private $cardRepository;

    /**
     * CardGenerator constructor.
     * @param CardRepository $cardRepository
     */
    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    /**
     * @param Card $card
     * @return Card
     */
    public function generateCard(Card $card): Card
    {
        # Génération de la carte
        $card->setCustomerCode($this->generateCustomerCode())
            ->setCheckSum(($card->getStore()->getCenterCode() + $card->getCustomerCode()) % 9);

        # Retour de la carte mise à jour
        return $card;
    }

    /**
     * Générer un code client aléatoire
     * @return string
     */
    public function generateCustomerCode(): string
    {
        $randCode = mt_rand(1,999999);

        $findSameCustomerCode = $this->cardRepository->findBy([
            'customerCode' => $randCode
        ]);

        if ($findSameCustomerCode) {
            $this->generateCustomerCode();
        }

        return sprintf("%06s",$randCode);
    }

}