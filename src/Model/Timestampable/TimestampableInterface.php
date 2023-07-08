<?php

declare(strict_types=1);

namespace App\Model\Timestampable;

interface TimestampableInterface
{
    public function setCreatedAt(\DateTimeImmutable $createdAt): self;

    public function getCreatedAt(): ?\DateTimeImmutable;

    public function setUpdatedAt(\DateTime $createdAt): self;

    public function getUpdatedAt(): ?\DateTime;

    public function initTimestampableFields(): void;
}
