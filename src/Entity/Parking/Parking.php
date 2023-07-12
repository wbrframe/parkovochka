<?php

declare(strict_types=1);

namespace App\Entity\Parking;

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
}
