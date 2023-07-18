<?php

namespace App\Enum;

enum ParkingTrafficEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case LARGE = 'large';

    public static function values(): array
    {
        return [
            self::LOW->value,
            self::MEDIUM->value,
            self::LARGE->value,
        ];
    }
}
