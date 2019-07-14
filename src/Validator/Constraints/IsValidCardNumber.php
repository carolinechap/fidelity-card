<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 14/07/2019
 * Time: 17:44
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class IsValidCardNumber
 * @package App\Validator\Constraints
 */
class IsValidCardNumber extends Constraint
{
    /**
     * @var string
     */
    public $message =
        'The card number "{{ cardnumber }}" is not a valid card number.';
}