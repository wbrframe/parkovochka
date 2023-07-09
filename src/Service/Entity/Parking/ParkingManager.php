<?php

declare(strict_types=1);

namespace App\Service\Entity\Parking;

use App\DTO\Parking\NewParkingDto;
use App\Entity\Parking\Parking;
use App\Service\Entity\Geo\CoordinateManager;

readonly class ParkingManager
{
    public function __construct(private CoordinateManager $coordinateManager)
    {
    }

    public function createEntityFromDto(NewParkingDto $dto): Parking
    {
        $coordinate = $this->coordinateManager->createEntityFromDto($dto->getCoordinate());

        return new Parking($coordinate, $dto->getAddress(), $dto->getGooglePlaceId());
    }
}
