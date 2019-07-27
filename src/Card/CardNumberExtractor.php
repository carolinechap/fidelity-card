<?php


namespace App\Card;


/**
 * Class CardNumberExtractor
 * @package App\Card
 */
class CardNumberExtractor
{
    /**
     * @param $value
     * @return array
     */
    public function evaluate($value) {
        if (strpos($value, '-') !== false) {
            //enter a code with delimiter like in placeholder
            $numberPieces = explode ('-', $value);
            $codeCentre = $numberPieces[0];
            $codeCarte = $numberPieces[1];
            $checkSum = $numberPieces[2];
        } else {
            //without delimiter
            $codeCentre = substr($value, 0, 3);
            $codeCarte = substr($value, 3, 6);
            $checkSum = substr($value, 9, 1);
        }
        return [
            'code_centre' => $codeCentre,
            'code_carte' => $codeCarte,
            'checksum' => intval($checkSum)
        ];
    }

}