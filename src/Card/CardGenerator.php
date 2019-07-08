<?php


namespace App\Card;


use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;

class CardGenerator
{

    public function generateCard(Card $card): Card
    {

        # Génération de la carte
        $card->setCustomerCode($this->generateCustomerCode())
            ->setCheckSum(($card->getStore()->getCenterCode() + $card->getCustomerCode()) % 9)
            ->setStatut(['PRE_ACTIVATED']);

        # Retour de la carte mise à jour
        return $card;
    }

    /**
     * Générer un code client aléatoire
     * @return int
     */
    private function generateCustomerCode(): int {
        $randCode = mt_rand(1,999999);
        return sprintf("%06s",$randCode);
        //TODO: Rendre le numéro unique

    }

}