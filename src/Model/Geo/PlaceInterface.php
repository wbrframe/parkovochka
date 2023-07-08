<?php

declare(strict_types=1);

namespace App\Model\Geo;

interface PlaceInterface
{
    public function getGooglePlaceId(): ?string;

    public function getAddress(): ?string;

    public function getCoordinate(): CoordinateInterface;
}
