<?php

declare(strict_types=1);

namespace App\Model\UUID;

trait UuidTrait
{
    public function getId(): string
    {
        return (string) $this->id;
    }
}
