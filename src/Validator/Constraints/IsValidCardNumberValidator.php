<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 14/07/2019
 * Time: 17:47
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidCardNumberValidator extends ConstraintValidator
{

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

        if (!is_int($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'integer');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        //Faire la regex correspondante au numéro de carte
//        if (!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches)) {
//            $this->context->buildViolation($constraint->message)
//                ->setParameter('{{ integer }}', $value)
//                ->addViolation();
//        }
    }
}