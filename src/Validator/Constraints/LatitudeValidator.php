<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LatitudeValidator extends ConstraintValidator
{
    const REGEX = '/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/';

    public function validate($value, Constraint $constraint): void
    {
        if (!preg_match(LatitudeValidator::REGEX, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}