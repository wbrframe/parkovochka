<?php

declare(strict_types=1);

namespace App\DTO\Parking;

use App\DTO\DtoInterface;
use App\DTO\Geo\CoordinateDto;
use App\Model\Geo\PlaceInterface;
use Symfony\Component\Validator\Constraints as Assert;

class NewParkingDto implements DtoInterface, PlaceInterface
{
    #[Assert\Sequentially([
        new Assert\Type('string'),
        new Assert\Length(min: 1, max: 500),
    ])]
    private string $address;

    #[Assert\Sequentially([
        new Assert\Length(min: 1, max: 1000),
    ])]
    private string $googlePlaceId;

    #[Assert\Valid]
    private CoordinateDto $coordinate;

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
}
