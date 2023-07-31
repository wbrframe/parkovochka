<?php

declare(strict_types=1);

namespace App\Entity\File;

use App\Entity\File\Parking\ParkingPhotoFile;
use Doctrine\ORM\Mapping as ORM;
use StfalconStudio\ApiBundle\Model\Aggregate\AggregateRootInterface;
use StfalconStudio\ApiBundle\Model\Timestampable\TimestampableInterface;
use StfalconStudio\ApiBundle\Model\Timestampable\TimestampableTrait;
use StfalconStudio\ApiBundle\Model\UUID\UuidInterface;
use StfalconStudio\ApiBundle\Model\UUID\UuidTrait;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'file_relations')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    AbstractFileRelation::TYPE_PARKING_PHOTO => ParkingPhotoFile::class,
])]
abstract class AbstractFileRelation implements TimestampableInterface, UuidInterface
{
    use TimestampableTrait;
    use UuidTrait;

    public const TYPE_PARKING_PHOTO = 'parking_photo';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    protected UuidV4 $id;

    #[ORM\OneToOne(inversedBy: 'relation', targetEntity: File::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(unique: true, nullable: false)]
    #[Assert\Valid]
    protected File $file;

    public function __construct(File $file)
    {
        $this->id = new UuidV4();
        $this->file = $file;
        $this->initTimestampableFields();
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }

    abstract public function getParentEntity(): AggregateRootInterface;
}
