<?php

declare(strict_types=1);

namespace App\Entity\File\Parking;

use App\Entity\File\AbstractFileRelation;
use App\Entity\File\File;
use App\Entity\Parking\Parking;
use Doctrine\ORM\Mapping as ORM;
use StfalconStudio\ApiBundle\Model\Aggregate\AggregatePartInterface;
use StfalconStudio\ApiBundle\Model\Aggregate\AggregateRootInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'file_parking_photos')]
class ParkingPhotoFile extends AbstractFileRelation implements AggregatePartInterface
{
    #[ORM\OneToOne(inversedBy: 'photo', targetEntity: Parking::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'cascade')]
    #[Assert\NotNull]
    private Parking $parking;

    public function __construct(File $file, Parking $parking)
    {
        parent::__construct($file);

        $this->parking = $parking;
    }

    public function getParking(): Parking
    {
        return $this->parking;
    }

    public function setParking(Parking $parking): void
    {
        $this->parking = $parking;
    }

    public function getParentEntity(): Parking
    {
        return $this->parking;
    }

    public function getAggregateRoot(): AggregateRootInterface
    {
        return $this->parking;
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
