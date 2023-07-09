<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\Http\Validation\InvalidEntityException;
use App\Traits\ValidatorTrait;
use Symfony\Component\Validator\Constraint;

class EntityValidator
{
    use ValidatorTrait;

    public function validate(mixed $entity, Constraint|array $constraints = null, array $groups = null): void
    {
        $errors = $this->validator->validate($entity, $constraints, $groups);

        if (\count($errors) > 0) {
            throw new InvalidEntityException($errors);
        }
    }
}
