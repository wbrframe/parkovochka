<?php

declare(strict_types=1);

namespace App\Controller\API\V10\File;

use App\Entity\File\File;
use App\Request\RequestHelper;
use App\Service\File\FileResponseBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ViewFileAction
{
    private FileResponseBuilderInterface $fileResponseBuilder;

    public function __construct(FileResponseBuilderInterface $fileResponseBuilder)
    {
        $this->fileResponseBuilder = $fileResponseBuilder;
    }

    #[Route(path: '/files/{id}', name: 'api_v1.0_view_file', requirements: ['id' => RequestHelper::UUID_REGEX], methods: [Request::METHOD_GET])]
    public function __invoke(File $file): Response
    {
        return $this->fileResponseBuilder->getFileResponse($file);
    }
}
