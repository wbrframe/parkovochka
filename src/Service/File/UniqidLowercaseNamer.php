<?php

declare(strict_types=1);

namespace App\Service\File;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\UniqidNamer;

class UniqidLowercaseNamer implements NamerInterface
{
    private readonly UniqidNamer $uniqidNamer;

    public function __construct(UniqidNamer $uniqidNamer)
    {
        $this->uniqidNamer = $uniqidNamer;
    }

    public function name($object, PropertyMapping $mapping): string
    {
        return mb_strtolower($this->uniqidNamer->name($object, $mapping));
    }
}
