<?php

declare(strict_types=1);

namespace App\Entity\Parking;

use App\Enum\ParkingCapacityEnum;
use App\Enum\ParkingTrafficEnum;
use App\Model\Geo\Coordinate;
use App\Model\Geo\PlaceInterface;
use Doctrine\ORM\Mapping as ORM;
use StfalconStudio\ApiBundle\Model\Timestampable\TimestampableInterface;
use StfalconStudio\ApiBundle\Model\Timestampable\TimestampableTrait;
use StfalconStudio\ApiBundle\Model\UUID\UuidInterface;
use StfalconStudio\ApiBundle\Model\UUID\UuidTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'parkings')]
#[ORM\UniqueConstraint(columns: ['google_place_id'])]
#[UniqueEntity(fields: 'googlePlaceId', ignoreNull: true)]
class Parking implements UuidInterface, TimestampableInterface, PlaceInterface
{
    use TimestampableTrait;
    use UuidTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    protected UuidV4 $id;

    #[ORM\Column(type: 'string', length: 500)]
    #[Assert\Sequentially([
        new Assert\Type('string'),
        new Assert\Length(min: 1, max: 500),
    ])]
    private string $address;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    #[Assert\Sequentially([
        new Assert\Length(min: 1, max: 1000),
    ])]
    private ?string $googlePlaceId = null;

    #[ORM\Column(type: 'geometry', options: ['geometry_type' => 'POINT'])]
    #[Assert\Valid]
    private Coordinate $coordinate;

    #[ORM\Column(enumType: ParkingCapacityEnum::class)]
    #[Assert\NotNull]
    private ParkingCapacityEnum $capacity;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    private bool $security;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    private bool $light;

    #[ORM\Column(enumType: ParkingTrafficEnum::class)]
    #[Assert\NotNull]
    private ParkingTrafficEnum $traffic;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    private bool $weatherProtection;

    #[ORM\Column(type: 'integer')]
    #[Assert\Sequentially(
        constraints: [
            new Assert\NotNull(),
            new Assert\Range(min: 0, max: 10),
        ]
    )]
    private int $userRating;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    #[Assert\Sequentially([
        new Assert\Length(min: 1, max: 500),
    ])]
    private ?string $description = null;

    public function __construct()
    {
        $this->id = new UuidV4();
        $this->initTimestampableFields();
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getGooglePlaceId(): ?string
    {
        return $this->googlePlaceId;
    }

    public function setGooglePlaceId(?string $googlePlaceId): void
    {
        $this->googlePlaceId = $googlePlaceId;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function setCoordinate(Coordinate $coordinate): void
    {
        $this->coordinate = $coordinate;
    }

    public function getCapacity(): ParkingCapacityEnum
    {
        return $this->capacity;
    }

    public function setCapacity(ParkingCapacityEnum $capacity): void
    {
        $this->capacity = $capacity;
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

    public function getTraffic(): ParkingTrafficEnum
    {
        return $this->traffic;
    }

    public function setTraffic(ParkingTrafficEnum $traffic): void
    {
        $this->traffic = $traffic;
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
        $this->description = $description;
    }
}
