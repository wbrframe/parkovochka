<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Model\UUID\UuidInterface;

class CircularReferenceHandler
{
    public function __invoke(UuidInterface $object): callable
    {
        return static function () use ($object) {
            return $object->getId();
        };
    }
}
