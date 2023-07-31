<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\File\File;
use App\Service\File\FileHelper;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FileNormalizer implements NormalizerInterface
{
    private readonly FileHelper $fileHelper;

    public function __construct(FileHelper $fileHelper)
    {
        $this->fileHelper = $fileHelper;
    }

    public function supportsNormalization(mixed $entity, string $format = null, array $context = []): bool
    {
        return $entity instanceof File;
    }

    public function normalize(mixed $file, string $format = null, array $context = []): ?array
    {
        $data = null;

        if ($file instanceof File) {
            $id = $file->getId();

            $data = [
                'id' => $id,
                'url' => $this->normalizeFileUrl($file),
                'width' => $file->getFileWidth(),
                'height' => $file->getFileHeight(),
                'mimeType' => $file->getFile()->getMimetype(),
            ];
        }

        return $data;
    }

    private function normalizeFileUrl(File $file): ?string
    {
        return $this->fileHelper->buildFileUrl($file);
    }
}
