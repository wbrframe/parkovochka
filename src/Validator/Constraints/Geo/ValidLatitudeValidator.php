<?php

declare(strict_types=1);

namespace App\Validator\Constraints\Geo;

use StfalconStudio\ApiBundle\Exception\Validator\UnexpectedConstraintException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\RangeValidator;

class ValidLatitudeValidator extends RangeValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidLatitude) {
            throw new UnexpectedConstraintException($constraint, ValidLatitude::class);
        }

        parent::validate($value, $constraint);
    }
}
