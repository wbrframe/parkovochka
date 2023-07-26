<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer\Enum;

use App\Enum\CapacityEnum;
use App\Serializer\Normalizer\AbstractBaseNormalizer;
use App\Util\TranslatorDomains;
use StfalconStudio\ApiBundle\Traits\TranslatorTrait;

class CapacityTypeEnumNormalizer extends AbstractBaseNormalizer
{
    use TranslatorTrait;

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof CapacityEnum;
    }

    /**
     * @param CapacityEnum $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return [
            'value' => $object->value,
            'name' => $this->translator->trans($object->value, [], TranslatorDomains::ENUM),
        ];
    }
}
