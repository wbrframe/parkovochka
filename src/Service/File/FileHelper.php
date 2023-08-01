<?php

declare(strict_types=1);

namespace App\Service\File;

use App\Entity\File\File;
use League\Flysystem\FilesystemOperator;
use StfalconStudio\ApiBundle\Traits\RouterTrait;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File as UploadedFile;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FileHelper
{
    use RouterTrait;

    public const MIME_TYPES_SUPPORT = [
        'image/png',
        'image/jpeg',
        'image/gif'
    ];

    public function __construct(private FilesystemOperator $filesystem, private string $staticHost)
    {
    }

    public function buildFileUrl(File $file): ?string
    {
        $uploadableFile = $file->getUploadableFile();

        return $uploadableFile instanceof UploadedFile ? $this->generateObjectUrlForCDN($uploadableFile) : null;
    }

    public function removeFileFromStorage(File $file): void
    {
        $uploadedFile = $file->getUploadableFile();
        if ($uploadedFile instanceof UploadedFile) {
            $this->filesystem->delete($uploadedFile->getPathname());
        }
    }

    private function generateObjectUrlForCDN(UploadedFile $file): string
    {
        return sprintf('%s/%s', $this->staticHost, $file->getPathname());
    }
}
