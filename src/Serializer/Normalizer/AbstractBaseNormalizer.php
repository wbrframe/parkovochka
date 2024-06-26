<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use Fresh\DateTime\DateTimeHelper;
use StfalconStudio\ApiBundle\Exception\DomainException;
use StfalconStudio\ApiBundle\Model\Timestampable\TimestampableInterface;
use StfalconStudio\ApiBundle\Model\UUID\UuidInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractBaseNormalizer implements NormalizerInterface
{
    protected const DEFAULT_FORMAT = 'json';

    protected DateTimeNormalizer $dateTimeNormalizer;
    protected DateTimeHelper $dateTimeHelper;

    #[Required]
    public function setDateTimeNormalizer(DateTimeNormalizer $dateTimeNormalizer): void
    {
        $this->dateTimeNormalizer = $dateTimeNormalizer;
    }

    #[Required]
    public function setDateTimeHelper(DateTimeHelper $dateTimeHelper): void
    {
        $this->dateTimeHelper = $dateTimeHelper;
    }

    protected function normalizeUuid(UuidInterface $entity, array &$data, string $key = null): void
    {
        if (null === $key) {
            $key = 'id';
        }

        $data[$key] = $entity->getId();
    }

    protected function includeTimestampableFields(TimestampableInterface $entity, array &$data): void
    {
        $data['createdAt'] = $this->dateTimeNormalizer->normalize($entity->getCreatedAt());
        $data['updatedAt'] = $this->dateTimeNormalizer->normalize($entity->getUpdatedAt());
    }

    protected function includeServerCurrentTime(array &$data): void
    {
        $data['serverCurrentTime'] = $this->dateTimeNormalizer->normalize($this->dateTimeHelper->getCurrentDatetimeImmutableUtc());
    }

    protected function getSerializationGroupFromContext(array $context): string
    {
        $serializationGroup = null;
        $contextType = 'group';

        if (\array_key_exists($contextType, $context) && \is_string($context[$contextType])) {
            $serializationGroup = $context[$contextType];
        }

        if (!\is_string($serializationGroup)) {
            throw new DomainException('Serialization group is not a valid string');
        }

        return $serializationGroup;
    }
}
