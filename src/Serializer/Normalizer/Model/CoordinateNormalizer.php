<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer\Model;

use App\Model\Geo\CoordinateInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CoordinateNormalizer implements NormalizerInterface
{
    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof CoordinateInterface;
    }

    /**
     * @param CoordinateInterface $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return [
            'longitude' => $object->getLongitude(),
            'latitude' => $object->getLatitude(),
        ];
    }
}
