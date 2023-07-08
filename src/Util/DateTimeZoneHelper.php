<?php

declare(strict_types=1);

namespace App\Util;

class DateTimeZoneHelper
{
    private const PERMITTED_UTC_NAMES = ['UTC', '+00:00'];

    public function isUTC(\DateTimeInterface $dateTime): bool
    {
        return \in_array($dateTime->getTimezone()->getName(), self::PERMITTED_UTC_NAMES, true);
    }
}
