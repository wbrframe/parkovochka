<?php

declare(strict_types=1);

namespace App\Validator\Constraints\Geo;

use StfalconStudio\ApiBundle\Exception\Validator\UnexpectedConstraintException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\RangeValidator;

class ValidLongitudeValidator extends RangeValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidLongitude) {
            throw new UnexpectedConstraintException($constraint, ValidLongitude::class);
        }

        parent::validate($value, $constraint);
    }
}
