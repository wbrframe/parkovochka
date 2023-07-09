<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exception\RuntimeException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait SymfonySerializerTrait
{
    /** @var SerializerInterface|Serializer */
    protected SerializerInterface|Serializer $symfonySerializer;

    #[Required]
    public function setSymfonySerializer(SerializerInterface $symfonySerializer): void
    {
        $this->symfonySerializer = $symfonySerializer;
    }

    public function getSymfonySerializer(): Serializer
    {
        if (!$this->symfonySerializer instanceof Serializer) {
            throw new RuntimeException(sprintf('Serializer is not instance of %s', Serializer::class));
        }

        return $this->symfonySerializer;
    }
}
