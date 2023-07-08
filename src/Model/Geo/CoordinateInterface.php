<?php

declare(strict_types=1);

namespace App\Model\Geo;

interface CoordinateInterface
{
    public function getLongitude(): float;

    public function getLatitude(): float;

    public function getAsString(): string;

    public function getAsPoint(bool $shortKeys = false): array;

    public function getFormattedForGoogleApiRequest(): string;
}
