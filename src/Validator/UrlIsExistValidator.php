<?php


namespace App\Validator;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class UrlIsExistValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UrlIsExist) {
            throw new UnexpectedTypeException($constraint, UrlIsExist::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!$this->validateUrl($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    private function validateUrl($url):bool
    {
        $client = HttpClient::create();
        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            return $statusCode>=200&&$statusCode<400;
        } catch (TransportExceptionInterface $e) {

        }
       return false;
    }
}