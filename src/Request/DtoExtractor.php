<?php

declare(strict_types=1);

namespace App\Request;

use App\DTO\DtoInterface;
use App\Exception\InvalidArgumentException;
use App\Service\AttributeProcessor\DtoAttributeProcessor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class DtoExtractor
{
    public function __construct(private readonly DtoAttributeProcessor $dtoAttributeProcessor, private readonly SerializerInterface $serializer)
    {
    }

    public function getDtoFromRequestForControllerClass(Request $request, string $controllerClassName, object $objectToPopulate = null): DtoInterface
    {
        $dtoClassName = $this->dtoAttributeProcessor->processAttributeForClass($controllerClassName);

        return $this->getDtoFromRequestForDtoClass($request, $dtoClassName, $objectToPopulate);
    }

    public function getDtoFromRequestForDtoClass(Request $request, string $dtoClassName, object $objectToPopulate = null): DtoInterface
    {
        $context = [];
        if (null !== $objectToPopulate) {
            $context = [AbstractNormalizer::OBJECT_TO_POPULATE => $objectToPopulate];
        }

        $object = $this->serializer->deserialize($request->getContent(), $dtoClassName, 'json', $context);

        if (!$object instanceof DtoInterface) {
            throw new InvalidArgumentException(sprintf('DtoExtractor supports only classes which implement %s', DtoInterface::class));
        }

        return $object;
    }
}
