<?php

declare(strict_types=1);

namespace App\Service\File;

use App\Entity\File\File as ApplicationFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class LocalFileResponseBuilder implements FileResponseBuilderInterface
{
    private readonly UploaderHelper $uploaderHelper;

    public function __construct(UploaderHelper $uploadHelper)
    {
        $this->uploaderHelper = $uploadHelper;
    }

    public function getFileResponse(ApplicationFile $file): Response
    {
        $uploadableFile = $file->getUploadableFile();
        if (!$uploadableFile instanceof File) {
            throw new NotFoundHttpException('resource_not_found_exception_message');
        }

        return new BinaryFileResponse(
            new File((string) $this->uploaderHelper->asset($file, 'uploadableFile')),
            Response::HTTP_OK,
            [
                'Content-Type' => $file->getFile()->getMimetype(),
            ]
        );
    }
}
