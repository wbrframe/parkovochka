<?php

declare(strict_types=1);

namespace App\Service\Entity\Parking;

use App\DTO\Parking\NewParkingDto;
use App\Entity\File\File;
use App\Entity\Parking\Parking;
use App\Exception\Http\FileNotFoundHttpException;
use App\Repository\File\FileRepository;

class ParkingFileManager
{
    public function __construct(private readonly FileRepository $fileRepository)
    {
    }

    public function updateEntityFromDtoForPhoto(Parking $entity, NewParkingDto $dto): void
    {
        $photoId = $dto->getPhotoId();
        if (null !== $photoId) {
            $file = $this->fileRepository->findOneById($photoId);
            if (!$file instanceof File) {
                throw new FileNotFoundHttpException($photoId);
            }

            $entity->setPhoto($file);
        } else {
            $entity->setPhoto(null);
        }
    }
}
