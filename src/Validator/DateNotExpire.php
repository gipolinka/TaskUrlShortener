<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class DateNotExpire extends Constraint
{
    public $message = 'Incorrect date entered';
}