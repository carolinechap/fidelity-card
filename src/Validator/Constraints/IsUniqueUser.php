<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class IsUniqueUser
 * @package App\Validator\Constraints
 * @Annotation
 */
class IsUniqueUser extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The user email is not valid';

}