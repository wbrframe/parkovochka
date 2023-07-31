<?php

declare(strict_types=1);

namespace App\Enum;

enum CapacityEnum: string
{
    case VALUE_1 = 'value_1';
    case VALUE_6 = 'value_6';
    case VALUE_10 = 'value_10';

    public static function values(): array
    {
        return [
            self::VALUE_1->value,
            self::VALUE_6->value,
            self::VALUE_10->value,
        ];
    }
}
