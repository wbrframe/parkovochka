<?php

declare(strict_types=1);

namespace App\Service\AttributeProcessor;

use App\Attribute\JsonSchema;
use App\Exception\InvalidArgumentException;
use App\Exception\RuntimeException;
use App\Util\File\FileReader;

class JsonSchemaAttributeProcessor
{
    private const JSON_FILE_EXTENSION = '.json';

    private array $cachedClasses = [];

    public function __construct(private readonly DtoAttributeProcessor $dtoAttributeProcessor, private readonly FileReader $fileReader, private readonly string $jsonSchemaDir)
    {
    }

    public function processAttributeForControllerClass(string $controllerClassName): mixed
    {
        $dtoClass = $this->dtoAttributeProcessor->processAttributeForClass($controllerClassName);

        return $this->processAttributeForDtoClass($dtoClass);
    }

    public function processAttributeForDtoClass(string $dtoClassName): mixed
    {
        /** @var class-string<object> $dtoClassName */
        if (\array_key_exists($dtoClassName, $this->cachedClasses)) {
            return $this->cachedClasses[$dtoClassName];
        }

        $reflector = new \ReflectionClass($dtoClassName);
        $attributes = $reflector->getAttributes(JsonSchema::class, \ReflectionAttribute::IS_INSTANCEOF);

        if (\count($attributes) > 1) {
            throw new RuntimeException(sprintf('Detected more than one JsonSchema attribute for class %s. Only one JsonSchema attribute allowed per class.', $dtoClassName));
        }
        if (1 !== \count($attributes)) {
            throw new RuntimeException(sprintf('Missing JsonSchema attribute for class %s', $dtoClassName));
        }

        $jsonSchemaDirPath = realpath($this->jsonSchemaDir);
        if (false === $jsonSchemaDirPath) {
            throw new RuntimeException(sprintf('Directory for json Schema files "%s" is not found.', $this->jsonSchemaDir));
        }

        $jsonSchemaFilename = $this->getJsonSchemaFilename($attributes[0]->getArguments()['jsonSchemaName']);

        $path = $jsonSchemaDirPath.\DIRECTORY_SEPARATOR.$jsonSchemaFilename;
        $realPathToJsonSchemaFile = realpath($path);
        if (false === $realPathToJsonSchemaFile) {
            throw new RuntimeException(sprintf('Json Schema file "%s" is not found.', $path));
        }

        $jsonSchemaContent = $this->fileReader->getFileContents($realPathToJsonSchemaFile);
        if (!\is_string($jsonSchemaContent)) {
            throw new InvalidArgumentException(sprintf('Cannot read content of file %s', $realPathToJsonSchemaFile));
        }

        $decodedSchema = json_decode($jsonSchemaContent, true, 512, \JSON_THROW_ON_ERROR);

        $this->cachedClasses[$dtoClassName] = $decodedSchema;

        return $decodedSchema;
    }

    /**
     * @param string $jsonSchemaName
     *
     * @return string
     */
    private function getJsonSchemaFilename(string $jsonSchemaName): string
    {
        $result = $jsonSchemaName;

        if (self::JSON_FILE_EXTENSION !== mb_substr($result, -5)) {
            $result .= self::JSON_FILE_EXTENSION;
        }

        return $result;
    }
}
