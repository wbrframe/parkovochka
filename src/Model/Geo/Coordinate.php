<?php

declare(strict_types=1);

namespace App\Model\Geo;

use App\Validator\Constraints as AppAssert;
use CrEOF\Spatial\PHP\Types\Geography\Point;
use StfalconStudio\ApiBundle\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Constraints as Assert;

class Coordinate extends Point implements CoordinateInterface
{
    public function __construct(float $longitude, float $latitude, int $spatialReferenceId = null)
    {
        parent::__construct($longitude, $latitude, $spatialReferenceId);
    }

    public function __toString(): string
    {
        return sprintf(
            'POINT(%f %f)',
            number_format($this->getLongitude(), 8),
            number_format($this->getLatitude(), 8)
        );
    }

    public static function createFromArray(array $array): self
    {
        if (!isset($array['latitude'], $array['longitude'])) {
            throw new UnexpectedValueException('Missing required keys: latitude, longitude');
        }

        return new Coordinate($array['longitude'], $array['latitude']);
    }

    #[Assert\NotNull]
    #[AppAssert\Geo\ValidLongitude]
    public function getLongitude(): float
    {
        return $this->getX();
    }

    #[Assert\NotNull]
    #[AppAssert\Geo\ValidLatitude]
    public function getLatitude(): float
    {
        return $this->getY();
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

    public function isEqual(Coordinate $coordinate): bool
    {
        $equalLatitude = $this->getLatitude() === $coordinate->getLatitude();
        $equalLongitude = $this->getLongitude() === $coordinate->getLongitude();

        $equalSrid = true;
        if (null !== $this->getSrid() || null !== $coordinate->getSrid()) {
            $equalSrid = $this->getSrid() === $coordinate->getSrid();
        }

        return $equalLatitude && $equalLongitude && $equalSrid;
    }

    public function getFormattedForGoogleApiRequest(): string
    {
        $formattedLatitude = number_format($this->getLatitude(), 8);
        $formattedLongitude = number_format($this->getLongitude(), 8);

        return sprintf('%s,%s', $formattedLatitude, $formattedLongitude);
    }
}
