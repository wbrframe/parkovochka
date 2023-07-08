<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM\Parking;

use App\Entity\Parking\Parking;
use App\Model\Geo\Coordinate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ParkingFixtures extends Fixture
{
    private array $parkingItems = [
        [
            'coordinate' => [
                'longitude' => -89.519,
                'latitude' => 34.366,
            ],
            'address' => 'sdfdsfsdf',
            'googlePlaceId' => 'dfdf',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->parkingItems as $item) {
            $coordinate = new Coordinate($item['coordinate']['longitude'], $item['coordinate']['latitude']);

            $product = new Parking($coordinate, $item['address'], $item['googlePlaceId']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
