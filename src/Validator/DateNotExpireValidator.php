<?php


namespace App\Validator;


use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class DateNotExpireValidator extends ConstraintValidator

{
    public function validate($value, Constraint $constraint)
    {
        // TODO: Implement validate() method.
        if (!$constraint instanceof DateNotExpire) {
            throw new UnexpectedTypeException($constraint, DateNotExpire::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if ($this->dateIsExpire($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value->format("Y-m-d"))
                ->addViolation();
        }
    }

    private function dateIsExpire($value)
    {
        $currentDate=new DateTime();
        $diff=$currentDate->diff($value);
        return $diff->invert&&$diff->d>0;
    }


}