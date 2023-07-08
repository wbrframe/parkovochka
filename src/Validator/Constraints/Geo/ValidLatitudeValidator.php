<?php

declare(strict_types=1);

namespace App\Validator\Constraints\Geo;

use App\Exception\Validator\UnexpectedConstraintException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\RangeValidator;

class ValidLatitudeValidator extends RangeValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidLatitude) {
            throw new UnexpectedConstraintException($constraint, ValidLatitude::class);
        }

        parent::validate($value, $constraint);
    }
}
