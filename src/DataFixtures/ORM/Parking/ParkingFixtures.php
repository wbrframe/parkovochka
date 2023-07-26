<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM\Parking;

use App\DataFixtures\ORM\FixtureHelper;
use App\Entity\Parking\Parking;
use App\Enum\CapacityEnum;
use App\Enum\TrafficEnum;
use App\Model\Geo\Coordinate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class ParkingFixtures extends Fixture
{
    private array $parkingItems = [
        [
            'coordinate' => [
                'latitude' => 48.6087147,
                'longitude' => 22.267764,
            ],
            'address' => 'вулиця Легоцького, 19а, Ужгород, Закарпатська область, Украина, 88000',
            'googlePlaceId' => 'ChIJNZrpnPkYOUcRD1ttXtj5V1k',
        ],
        [
            'coordinate' => [
                'latitude' => 48.607652,
                'longitude' => 22.267820,
            ],
            'address' => 'ул. Легоцкого, 21, Ужгород, Закарпатская область, 88000',
            'googlePlaceId' => '0ahUKEwii4ePZmYCAAxVj1gIHHUf6BbMQ8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.612211,
                'longitude' => 22.266562,
            ],
            'address' => 'Сільпо, ул. Капушанская, 150, Ужгород, Закарпатська область, 88000',
            'googlePlaceId' => '0ahUKEwiHhtiVmoCAAxWQ4aQKHW27DVoQ8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.604457,
                'longitude' => 22.275633,
            ],
            'address' => 'АТБ-Маркет, вулиця 8-го Березня, 48, Ужгород, Закарпатська область, 88000',
            'googlePlaceId' => '0ahUKEwivncjCmoCAAxXM_aQKHdHhDRcQ8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.624336,
                'longitude' => 22.295642,
            ],
            'address' => 'пл. Почтовая, Ужгород, Закарпатська область, 88000',
            'googlePlaceId' => '0ahUKEwiy3JnmmoCAAxUwzgIHHQ_7CnkQ8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.625670,
                'longitude' => 22.293883,
            ],
            'address' => 'ул. Крылова, 2, Ужгород, Закарпатская область, 88000',
            'googlePlaceId' => '0ahUKEwi7htOFm4CAAxWUG-wKHVWjC60Q8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.614691,
                'longitude' => 22.290975,
            ],
            'address' => 'ул. Заньковецкой, 2, Ужгород, Закарпатская область, 88000',
            'googlePlaceId' => '0ahUKEwiyk_2vm4CAAxWatqQKHfDvD0oQ8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.621500,
                'longitude' => 22.288658,
            ],
            'address' => 'площадь Богдана Хмельницкого, Ужгород, Закарпатская область, 88000',
            'googlePlaceId' => '0ahUKEwiVi7DFm4CAAxWE7qQKHZlbCikQ8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.616024,
                'longitude' => 22.301790,
            ],
            'address' => 'ул. Русская, 20-40, Ужгород, Закарпатская область, 88000',
            'googlePlaceId' => '0ahUKEwjXiL_Wm4CAAxXo2gIHHQToCVMQ8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.613357,
                'longitude' => 22.292348,
            ],
            'address' => 'площадь Кирилла и Мефодия, Ужгород, Закарпатская область, 88000',
            'googlePlaceId' => '0ahUKEwiXwvnvm4CAAxU7wQIHHTdUAZ4Q8BcIAigA',
        ],
        [
            'coordinate' => [
                'latitude' => 48.621166,
                'longitude' => 22.287732,
            ],
            'address' => 'площадь Кирилла и Мефодия, Ужгород, Закарпатская область, 88000',
            'googlePlaceId' => null,
        ],
    ];

    private Generator $faker;

    public function __construct()
    {
        $this->faker = FixtureHelper::getFaker();
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->parkingItems as $item) {
            $coordinate = new Coordinate($item['coordinate']['longitude'], $item['coordinate']['latitude']);

            $parking = new Parking();
            $parking->setCoordinate($coordinate);
            $parking->setAddress($item['address']);
            $parking->setGooglePlaceId($item['googlePlaceId']);
            $parking->setCapacity($this->faker->randomElement(CapacityEnum::class));
            $parking->setSecurity($this->faker->boolean());
            $parking->setLight($this->faker->boolean());
            $parking->setTraffic($this->faker->randomElement(TrafficEnum::class));
            $parking->setWeatherProtection($this->faker->boolean());
            $parking->setUserRating($this->faker->numberBetween(0, 10));
            $parking->setDescription($this->faker->boolean() ? $this->faker->realText(100) : null);
            $manager->persist($parking);
        }

        $manager->flush();
    }
}
