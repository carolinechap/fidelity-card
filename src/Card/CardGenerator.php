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
        # Set customer code and checksum on card
        $card->setCustomerCode($this->generateCustomerCode())
            ->setCheckSum(($card->getStore()->getCenterCode() + $card->getCustomerCode()) % 9);

        # Return the card instance
        return $card;
    }

    /**
     * Generate a random customer code
     * 
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