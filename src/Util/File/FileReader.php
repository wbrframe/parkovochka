<?php

declare(strict_types=1);

namespace App\Util\File;

class FileReader
{
    public function getFileContents(string $filename): bool|string
    {
        return file_get_contents($filename);
    }
}
