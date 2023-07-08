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

    public function updateEntityFromDto(Coordinate $coordinate, CoordinateDto $coordinateDto): Coordinate
    {
        $newCoordinate = new Coordinate($coordinateDto->getLongitude(), $coordinateDto->getLatitude());

        if (!$newCoordinate->isEqual($coordinate)) {
            return $newCoordinate;
        }

        return $coordinate;
    }
}
