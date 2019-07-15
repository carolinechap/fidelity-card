<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 14/07/2019
 * Time: 17:47
 */

namespace App\Validator\Constraints;

use App\Repository\CardRepository;
use App\Repository\StoreRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Security\Core\Security;

class IsValidCardNumberValidator extends ConstraintValidator
{

    private $cardRepository;

    private $storeRepository;

    private $security;


    public function __construct(CardRepository $cardRepository,
                                StoreRepository $storeRepository,
                                Security $security)
    {
        $this->cardRepository = $cardRepository;
        $this->storeRepository = $storeRepository;
        $this->security = $security;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsValidCardNumber) {
            throw new UnexpectedTypeException($constraint, IsValidCardNumber::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        if (!preg_match('/^([0-9 \-]+)$/', $value, $matches)) {
            $this->context->buildViolation('card.number.not_match_regex')
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        $codeCentre = $this->evaluate($value)['code_centre'];
        if (strlen($codeCentre) !== 3) {
            $this->context->buildViolation('card.number.range_code_center')
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        $customerCode = $this->evaluate($value)['code_carte'];
        if (strlen($customerCode) !== 6) {
            $this->context->buildViolation('card.number.range_customer_code')
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        $checkSum = (intval($codeCentre) + intval($customerCode))% 9;
        if (strlen($checkSum) !== 1) {
            $this->context->buildViolation('card.number.wrong_checksum')
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        if ($checkSum !== $this->evaluate($value)['card.number.wrong_checksum'] ) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        if ($this->storeRepository->findOneBy(['centerCode' => $codeCentre])) {
            $this->context->buildViolation('card.number.not_existent_code_center')
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        if ($this->cardRepository->findOneBy(['customerCode' => $customerCode])) {
            $this->context->buildViolation('card.number.not_existent_code_customer')
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    private function evaluate($value) {
        if (strpos('-', $value) != false) {
            //enter a code with delimiter like in placeholder
            $numberPieces = explode ('-', $value);
            $codeCentre = $numberPieces[0];
            $codeCarte = $numberPieces[1];
            $checkSum = $numberPieces[2];
        } else {
            //without delimiter
            $codeCentre = substr($value, 0, 3);
            $codeCarte = substr($value, 4, 6);
            $checkSum = substr($value, 11, 1);
        }
        return [
            'code_centre' => $codeCentre,
            'code_carte' => $codeCarte,
            'checksum' => intval($checkSum)
        ];
    }
}