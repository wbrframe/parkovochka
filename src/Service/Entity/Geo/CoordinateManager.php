<?php

declare(strict_types=1);

namespace App\Service\Entity\Geo;

use App\DTO\Geo\CoordinateDto;
use App\Model\Geo\Coordinate;

class CoordinateManager
{
    public function createEntityFromDto(CoordinateDto $coordinateDto): Coordinate
    {
        return new Coordinate($coordinateDto->getLongitude(), $coordinateDto->getLatitude());
    }

    public function createDtoFromEntity(Coordinate $coordinate): CoordinateDto
    {
        return (new CoordinateDto())
            ->setLatitude($coordinate->getLatitude())
            ->setLongitude($coordinate->getLongitude())
        ;
    }
}
