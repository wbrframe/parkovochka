<?php

declare(strict_types=1);

namespace App\DTO\Parking;

use App\DTO\Geo\CoordinateDto;
use App\Enum\ParkingCapacityEnum;
use App\Enum\ParkingTrafficEnum;
use App\Model\Geo\PlaceInterface;
use StfalconStudio\ApiBundle\Attribute\JsonSchema;
use StfalconStudio\ApiBundle\DTO\DtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[JsonSchema(jsonSchemaName: 'Parking/NewParking')]
class NewParkingDto implements DtoInterface, PlaceInterface
{
    #[Assert\Sequentially([
        new Assert\Length(min: 1, max: 500),
    ])]
    private string $address;

    #[Assert\Sequentially([
        new Assert\Length(min: 1, max: 1000),
    ])]
    private string $googlePlaceId;

    #[Assert\Valid]
    private CoordinateDto $coordinate;

    #[Assert\Sequentially(
        constraints: [
            new Assert\NotBlank(),
            new Assert\Choice(callback: [ParkingCapacityEnum::class, 'values']),
        ],
    )]
    private string $capacity = '';

    private bool $security;
    private bool $light;

    #[Assert\Sequentially(
        constraints: [
            new Assert\NotBlank(),
            new Assert\Choice(callback: [ParkingTrafficEnum::class, 'values']),
        ],
    )]
    private string $traffic = '';

    private bool $weatherProtection;

    #[Assert\Sequentially(
        constraints: [
            new Assert\Range(min: 0, max: 10),
        ]
    )]
    private int $userRating;

    #[Assert\Sequentially([
        new Assert\Length(min: 1, max: 500),
    ])]
    private ?string $description = null;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = trim($address);
    }

    public function getGooglePlaceId(): string
    {
        return $this->googlePlaceId;
    }

    public function setGooglePlaceId(string $googlePlaceId): void
    {
        $this->googlePlaceId = trim($googlePlaceId);
    }

    public function getCoordinate(): CoordinateDto
    {
        return $this->coordinate;
    }

    public function setCoordinate(CoordinateDto $coordinate): void
    {
        $this->coordinate = $coordinate;
    }

    public function getCapacity(): string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): void
    {
        $this->capacity = \trim($capacity);
    }

    public function isSecurity(): bool
    {
        return $this->security;
    }

    public function setSecurity(bool $security): void
    {
        $this->security = $security;
    }

    public function isLight(): bool
    {
        return $this->light;
    }

    public function setLight(bool $light): void
    {
        $this->light = $light;
    }

    public function getTraffic(): string
    {
        return $this->traffic;
    }

    public function setTraffic(string $traffic): void
    {
        $this->traffic = \trim($traffic);
    }

    public function isWeatherProtection(): bool
    {
        return $this->weatherProtection;
    }

    public function setWeatherProtection(bool $weatherProtection): void
    {
        $this->weatherProtection = $weatherProtection;
    }

    public function getUserRating(): int
    {
        return $this->userRating;
    }

    public function setUserRating(int $userRating): void
    {
        $this->userRating = $userRating;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        if (is_string($description)) {
            $this->description = \trim($description);
        } else {
            $this->description = $description;
        }
    }
}
