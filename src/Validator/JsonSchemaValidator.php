<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\Http\Json\InvalidJsonSchemaException;
use App\Exception\Http\Json\MalformedJsonException;
use App\Service\AttributeProcessor\JsonSchemaAttributeProcessor;
use App\Traits\SymfonySerializerTrait;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\Request;

class JsonSchemaValidator
{
    use SymfonySerializerTrait;

    public function __construct(private readonly Validator $validator, private readonly JsonSchemaAttributeProcessor $jsonSchemaAttributeProcessor)
    {
    }

    public function validateRequestForControllerClass(Request $request, string $controllerClassName): void
    {
        $data = $this->decodeJsonFromRequest($request);
        $jsonSchema = $this->jsonSchemaAttributeProcessor->processAttributeForControllerClass($controllerClassName);
        $this->doValidateRequestData($data, $jsonSchema);
    }

    public function validateRequestDataForDtoClass(Request $request, string $dtoClassName): void
    {
        $data = $this->decodeJsonFromRequest($request);
        $jsonSchema = $this->jsonSchemaAttributeProcessor->processAttributeForDtoClass($dtoClassName);
        $this->doValidateRequestData($data, $jsonSchema);
    }

    private function doValidateRequestData(mixed $requestData, mixed $jsonSchema): void
    {
        $this->validator->validate($requestData, $jsonSchema, Constraint::CHECK_MODE_NORMAL);

        if (!$this->validator->isValid()) {
            $violations = (array) $this->symfonySerializer->normalize($this->validator, 'json', ['jsonSchema' => $jsonSchema]); // @phpstan-ignore-line
            $normalizedJsonSchema = (array) $this->symfonySerializer->normalize($jsonSchema, 'object'); // @phpstan-ignore-line

            throw new InvalidJsonSchemaException($violations, $normalizedJsonSchema);
        }
    }

    private function decodeJsonFromRequest(Request $request): mixed
    {
        $data = json_decode((string) $request->getContent());

        if (null === $data) {
            throw new MalformedJsonException(sprintf('Format of your request is not a valid JSON. Error: %s', json_last_error_msg()));
        }

        return $data;
    }
}
