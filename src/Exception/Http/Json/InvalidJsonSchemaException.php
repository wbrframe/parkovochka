<?php

declare(strict_types=1);

namespace App\Exception\Http\Json;

use App\Error\BaseErrorNames;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidJsonSchemaException extends HttpException
{
    private readonly array $violations;
    private readonly array $jsonSchema;

    public function __construct(array $violations, array $jsonSchema, \Exception $previous = null)
    {
        $this->violations = $violations;
        $this->jsonSchema = $jsonSchema;

        parent::__construct(Response::HTTP_BAD_REQUEST, 'invalid_json_schema_exception_message', $previous);
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function getJsonSchema(): array
    {
        return $this->jsonSchema;
    }

    public function getErrorName(): string
    {
        return BaseErrorNames::INVALID_JSON_SCHEMA;
    }
}
