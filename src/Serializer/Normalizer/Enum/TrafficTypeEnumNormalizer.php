<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer\Enum;

use App\Enum\TrafficEnum;
use App\Serializer\Normalizer\AbstractBaseNormalizer;
use App\Util\TranslatorDomains;
use StfalconStudio\ApiBundle\Traits\TranslatorTrait;

class TrafficTypeEnumNormalizer extends AbstractBaseNormalizer
{
    use TranslatorTrait;

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof TrafficEnum;
    }

    /**
     * @param TrafficEnum $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return [
            'value' => $object->value,
            'name' => $this->translator->trans($object->value, [], TranslatorDomains::ENUM),
        ];
    }
}
