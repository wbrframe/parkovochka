<?php

declare(strict_types=1);

namespace App\Service\Entity\Parking;

use App\DTO\Parking\NewParkingDto;
use App\Entity\Parking\Parking;
use App\Enum\CapacityEnum;
use App\Enum\TrafficEnum;
use App\Service\Entity\Geo\CoordinateManager;

readonly class ParkingManager
{
    public function __construct(private CoordinateManager $coordinateManager)
    {
    }

    public function createEntityFromDto(NewParkingDto $dto): Parking
    {
        $coordinate = $this->coordinateManager->createEntityFromDto($dto->getCoordinate());

        $entity = new Parking();
        $entity->setCoordinate($coordinate);
        $entity->setAddress($dto->getAddress());
        $entity->setGooglePlaceId($dto->getGooglePlaceId());
        $entity->setCapacity(CapacityEnum::from($dto->getCapacity()));
        $entity->setSecurity($dto->isSecurity());
        $entity->setLight($dto->isLight());
        $entity->setTraffic(TrafficEnum::from($dto->getTraffic()));
        $entity->setWeatherProtection($dto->isWeatherProtection());
        $entity->setUserRating($dto->getUserRating());
        $entity->setDescription($dto->getDescription());

        return $entity;
    }
}
