<?php

declare(strict_types=1);

namespace App\Traits;

use App\Validator\JsonSchemaValidator;
use Symfony\Contracts\Service\Attribute\Required;

trait JsonSchemaValidatorTrait
{
    protected JsonSchemaValidator $jsonSchemaValidator;

    #[Required]
    public function setJsonSchemaValidator(JsonSchemaValidator $jsonSchemaValidator): void
    {
        $this->jsonSchemaValidator = $jsonSchemaValidator;
    }
}
