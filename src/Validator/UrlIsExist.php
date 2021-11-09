<?php
namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UrlIsExist extends Constraint
{
    public $message = 'This URL is not active';
}
