<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\DtoInterface;
use App\Traits;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;

abstract class AbstractDtoBasedAction
{
    use Traits\DtoExtractorTrait;
    use Traits\EntityValidatorTrait;
    use Traits\JsonSchemaValidatorTrait;
    use Traits\SerializerTrait;

    /**
     * @param Request $request
     */
    protected function validateJsonSchema(Request $request): void
    {
        $this->jsonSchemaValidator->validateRequestForControllerClass($request, static::class);
    }

    /**
     * @param DtoInterface                 $dto
     * @param Constraint|Constraint[]|null $constraints
     * @param array|null                   $groups
     */
    protected function validateDto(DtoInterface $dto, Constraint|array $constraints = null, array $groups = null): void
    {
        $this->entityValidator->validate($dto, $constraints, $groups);
    }

    /**
     * @param object                       $entity
     * @param Constraint|Constraint[]|null $constraints
     * @param array|null                   $groups
     */
    protected function validateEntity(object $entity, Constraint|array $constraints = null, array $groups = null): void
    {
        $this->entityValidator->validate($entity, $constraints, $groups);
    }

    /**
     * @param Request     $request
     * @param object|null $objectToPopulate
     *
     * @return DtoInterface
     */
    protected function getDtoFromRequest(Request $request, object $objectToPopulate = null): DtoInterface
    {
        return $this->dtoExtractor->getDtoFromRequestForControllerClass($request, static::class, $objectToPopulate);
    }
}
