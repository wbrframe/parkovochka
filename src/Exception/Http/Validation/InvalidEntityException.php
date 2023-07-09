<?php

declare(strict_types=1);

namespace App\Exception\Http\Validation;

use App\Error\BaseErrorNames;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidEntityException extends HttpException
{
    private readonly ConstraintViolationListInterface $errors;

    public function __construct(ConstraintViolationListInterface $errors, \Exception $previous = null)
    {
        $this->errors = $errors;

        parent::__construct(Response::HTTP_UNPROCESSABLE_ENTITY, 'invalid_entity_exception_message', $previous);
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }

    public function getErrorName(): string
    {
        return BaseErrorNames::INVALID_ENTITY;
    }
}
