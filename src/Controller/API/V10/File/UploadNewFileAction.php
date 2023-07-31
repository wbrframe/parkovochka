<?php

declare(strict_types=1);

namespace App\Controller\API\V10\File;

use App\Entity\File\File;
use App\Serializer\Groups\SerializationGroups;
use App\Service\File\FileHelper;
use StfalconStudio\ApiBundle\Traits\EntityManagerTrait;
use StfalconStudio\ApiBundle\Traits\EntityValidatorTrait;
use StfalconStudio\ApiBundle\Traits\SerializerTrait;
use Symfony\Component\HttpFoundation\File\File as UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

final class UploadNewFileAction
{
    use EntityManagerTrait;
    use EntityValidatorTrait;
    use SerializerTrait;

    #[Route(path: '/files', name: 'api_v1.0_upload_new_file', methods: [Request::METHOD_POST])]
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UploadedFile $uploadFile */
        $uploadFile = $request->files->get('file');

        $this->entityValidator->validate(
            $uploadFile,
            [
                new NotNull(['message' => 'file_is_missed']),
                new Image([
                    'mimeTypes' => FileHelper::MIME_TYPES_SUPPORT,
                    'maxSize' => '3M',
                ]),
            ]
        );

        $file = new File();
        $file->setUploadableFile($uploadFile);

        $this->em->persist($file);
        $this->em->flush();

        $data = $this->serializer->serialize($file, SerializationGroups::VIEW_FILE_AS_ANONYMOUS);

        return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    }
}
