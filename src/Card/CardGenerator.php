<?php


namespace App\Card;


use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;

class CardGenerator
{

    public function generateCard(int $centerCode)
    {
        // customerCode
        $randCode = mt_rand(1,999999);
        $customerCode = sprintf("%06s",$randCode);

        // center code : parameter, from the form

        // checkSum :
        $checkSum = ($centerCode + $customerCode) % 9;

        // full code :
        return $centerCode . $customerCode . $checkSum;
    }

}