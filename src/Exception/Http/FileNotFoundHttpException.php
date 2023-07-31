<?php

declare(strict_types=1);

namespace App\Exception\Http;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileNotFoundHttpException extends NotFoundHttpException
{
    private string $id;

    public function __construct(string $id)
    {
        parent::__construct(sprintf('File `%s` not found', $id));
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
