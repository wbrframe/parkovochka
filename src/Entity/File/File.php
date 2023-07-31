<?php

declare(strict_types=1);

namespace App\Entity\File;

use App\Repository\File\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use StfalconStudio\ApiBundle\Model\Timestampable\TimestampableInterface;
use StfalconStudio\ApiBundle\Model\Timestampable\TimestampableTrait;
use StfalconStudio\ApiBundle\Model\UUID\UuidInterface;
use StfalconStudio\ApiBundle\Model\UUID\UuidTrait;
use Symfony\Component\HttpFoundation\File\File as UploadedFile;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: FileRepository::class)]
#[ORM\Table(name: 'files')]
#[Vich\Uploadable]
class File implements TimestampableInterface, UuidInterface
{
    use TimestampableTrait;
    use UuidTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV4 $id;

    #[ORM\Embedded(class: EmbeddedFile::class, columnPrefix: 'file_')]
    private EmbeddedFile $file;

    #[ORM\OneToOne(mappedBy: 'file', targetEntity: AbstractFileRelation::class)]
    private ?AbstractFileRelation $relation = null;

    #[Assert\NotBlank]
    #[Vich\UploadableField(mapping: 'files', fileNameProperty: 'file.name', size: 'file.size', mimeType: 'file.mimeType', originalName: 'file.originalName', dimensions: 'file.dimensions')]
    private ?UploadedFile $uploadableFile = null;

    public function __construct()
    {
        $this->id = new UuidV4();
        $this->file = new EmbeddedFile();
        $this->initTimestampableFields();
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getFile(): EmbeddedFile
    {
        return $this->file;
    }

    public function setFile(EmbeddedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getRelation(): ?AbstractFileRelation
    {
        return $this->relation;
    }

    public function setRelation(AbstractFileRelation $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getUploadableFile(): ?UploadedFile
    {
        return $this->uploadableFile;
    }

    public function setUploadableFile(?UploadedFile $uploadableFile): self
    {
        $this->uploadableFile = $uploadableFile;

        return $this;
    }

    #[Pure]
    public function getFileWidth(): ?int
    {
        return $this->getDimensionItem(0);
    }

    #[Pure]
    public function getFileHeight(): ?int
    {
        return $this->getDimensionItem(1);
    }

    public function setDimensions(?int $width, ?int $height): self
    {
        $this->file->setDimensions([$width, $height]);

        return $this;
    }

    #[Pure]
    private function getDimensionItem(int $key): ?int
    {
        $dimensions = $this->file->getDimensions();

        return \is_array($dimensions) && isset($dimensions[$key]) ? (int) $dimensions[$key] : null;
    }
}
