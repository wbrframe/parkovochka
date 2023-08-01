<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer\Entity\Parking;

use App\Entity\File\File;
use App\Entity\File\Parking\ParkingPhotoFile;
use App\Entity\Parking\Parking;
use App\Serializer\Groups\SerializationGroups;
use App\Serializer\Normalizer\AbstractBaseNormalizer;
use App\Serializer\Normalizer\FileNormalizer;
use App\Serializer\Normalizer\Model\CoordinateNormalizer;

class ParkingNormalizer extends AbstractBaseNormalizer
{
    public function __construct(
        private readonly CoordinateNormalizer $coordinateNormalizer,
        private readonly FileNormalizer $fileNormalizer
    )
    {
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Parking;
    }

    /**
     * @param Parking $object
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
                $this->normalizeCapacity($object, $data);
                $this->normalizeSecurity($object, $data);
                $this->normalizeLight($object, $data);
                $this->normalizeTraffic($object, $data);
                $this->normalizeWeatherProtection($object, $data);
                $this->normalizeUserRating($object, $data);
                $this->normalizeDescription($object, $data);
                $this->normalizePhoto($object, $data);
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

    private function normalizeCapacity(Parking $entity, array &$data): void
    {
        $data['capacity'] = $entity->getCapacity();
    }

    private function normalizeSecurity(Parking $entity, array &$data): void
    {
        $data['security'] = $entity->isSecurity();
    }

    private function normalizeLight(Parking $entity, array &$data): void
    {
        $data['light'] = $entity->isLight();
    }

    private function normalizeTraffic(Parking $entity, array &$data): void
    {
        $data['traffic'] = $entity->getTraffic();
    }

    private function normalizeWeatherProtection(Parking $entity, array &$data): void
    {
        $data['weatherProtection'] = $entity->isWeatherProtection();
    }

    private function normalizeUserRating(Parking $entity, array &$data): void
    {
        $data['userRating'] = $entity->getUserRating();
    }

    private function normalizeDescription(Parking $entity, array &$data): void
    {
        $data['description'] = $entity->getDescription();
    }

    private function normalizePhoto(Parking $entity, array &$data): void
    {
        $relatedFile = $entity->getPhoto();

        $data['photo'] = $relatedFile instanceof File ? $this->fileNormalizer->normalize($relatedFile) : null;
    }
}
