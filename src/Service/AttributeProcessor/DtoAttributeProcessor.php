<?php

declare(strict_types=1);

namespace App\Service\AttributeProcessor;

use App\Attribute\DTO;
use App\Exception\RuntimeException;

class DtoAttributeProcessor
{
    private array $cachedClasses = [];

    public function processAttributeForClass(string $className): string
    {
        /** @var class-string<object> $className */
        if (\array_key_exists($className, $this->cachedClasses)) {
            return $this->cachedClasses[$className];
        }

        $reflector = new \ReflectionClass($className);
        $attributes = $reflector->getAttributes(DTO::class, \ReflectionAttribute::IS_INSTANCEOF);

        if (\count($attributes) > 1) {
            throw new RuntimeException(sprintf('Detected more than one DTO attribute for class %s. Only one DTO attribute allowed per class.', $className));
        }
        if (1 !== \count($attributes)) {
            throw new RuntimeException(sprintf('Missing DTO attribute for class %s.', $className));
        }

        $class = $attributes[0]->getArguments()['class'];

        $this->cachedClasses[$className] = $class;

        return $class;
    }
}
