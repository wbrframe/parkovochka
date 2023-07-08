<?php

declare(strict_types=1);

namespace App\Exception\Validator;

use App\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraint;

class UnexpectedConstraintException extends InvalidArgumentException
{
    #[Pure]
    public function __construct(Constraint $constraint, string $expectedClass)
    {
        parent::__construct(sprintf('Object of class %s is not instance of %s', $constraint::class, $expectedClass));
    }
}
