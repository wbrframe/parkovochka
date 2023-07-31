<?php

declare(strict_types=1);

namespace App\Service\File;

use App\Entity\File\File;
use Symfony\Component\HttpFoundation\Response;

interface FileResponseBuilderInterface
{
    public function getFileResponse(File $file): Response;
}
