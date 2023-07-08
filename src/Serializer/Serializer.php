<?php

declare(strict_types=1);

namespace App\Serializer;

use Symfony\Component\Serializer\Serializer as BaseSerializer;
use Symfony\Component\Serializer\SerializerInterface;

class Serializer
{
    public const DEFAULT_FORMAT = 'json';

    public function __construct(protected readonly SerializerInterface|BaseSerializer $symfonySerializer)
    {
    }

    public function serialize(object|array $object, string $serializationGroup, array $context = []): string
    {
        $preparedContext = array_merge(
            $context,
            [
                'group' => $serializationGroup,
                'json_encode_options' => \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_UNICODE,
            ]
        );

        return $this->symfonySerializer->serialize($object, self::DEFAULT_FORMAT, $preparedContext);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        return $this->symfonySerializer->deserialize($data, $type, $format, $context);
    }
}
