<?php

declare(strict_types=1);

namespace App\DTO\Geo;

use App\Attribute\JsonSchema;
use App\DTO\DtoInterface;
use App\Model\Geo\CoordinateInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[JsonSchema('Geo/Coordinate')]
class CoordinateDto implements DtoInterface, CoordinateInterface
{
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    private float $latitude;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    private float $longitude;

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAsString(): string
    {
        return implode(
            ',',
            [
                $this->getLatitude(),
                $this->getLongitude(),
            ]
        );
    }

    public function getAsPoint(bool $shortKeys = false): array
    {
        if ($shortKeys) {
            $latitudeKey = 'lat';
            $longitudeKey = 'lng';
        } else {
            $latitudeKey = 'latitude';
            $longitudeKey = 'longitude';
        }

        return [
            $latitudeKey => $this->getLatitude(),
            $longitudeKey => $this->getLongitude(),
        ];
    }

    public function getFormattedForGoogleApiRequest(): string
    {
        $formattedLatitude = number_format($this->getLatitude(), 8);
        $formattedLongitude = number_format($this->getLongitude(), 8);

        return sprintf('%s,%s', $formattedLatitude, $formattedLongitude);
    }
}
