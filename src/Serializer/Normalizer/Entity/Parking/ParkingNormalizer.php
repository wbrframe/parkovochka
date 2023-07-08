<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer\Entity\Parking;

use App\Entity\Parking\Parking;
use App\Serializer\Groups\SerializationGroups;
use App\Serializer\Normalizer\AbstractBaseNormalizer;
use App\Serializer\Normalizer\Model\CoordinateNormalizer;

class ParkingNormalizer extends AbstractBaseNormalizer
{
    public function __construct(private readonly CoordinateNormalizer $coordinateNormalizer)
    {
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Parking;
    }

    /**
     * @param Parking     $object
     * @param string|null $format
     * @param array       $context
     *
     * @return array
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        $data = [];

        $serializationGroup = $this->getSerializationGroupFromContext($context);

        switch ($serializationGroup) {
            case SerializationGroups::LIST_PARKINGS_AS_ANONYMOUS:
                $this->normalizeId($object, $data);
                $this->normalizeAddress($object, $data);
                $this->normalizeGooglePlaceId($object, $data);
                $this->normalizeCoordinate($object, $data);
                break;
        }

        return $data;
    }

    private function normalizeId(Parking $entity, array &$data): void
    {
        $data['id'] = $entity->getId();
    }

    private function normalizeAddress(Parking $entity, array &$data): void
    {
        $data['address'] = $entity->getAddress();
    }

    private function normalizeGooglePlaceId(Parking $entity, array &$data): void
    {
        $data['googlePlaceId'] = $entity->getGooglePlaceId();
    }

    private function normalizeCoordinate(Parking $entity, array &$data): void
    {
        $data['coordinate'] = $this->coordinateNormalizer->normalize($entity->getCoordinate());
    }
}
