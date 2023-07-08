<?php

declare(strict_types=1);

namespace App\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
class JsonSchema
{
    public function __construct(private readonly string $jsonSchemaName)
    {
    }

    public function getJsonSchemaName(): string
    {
        return $this->jsonSchemaName;
    }
}
