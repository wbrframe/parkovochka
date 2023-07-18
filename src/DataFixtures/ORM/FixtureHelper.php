<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use Faker\Factory;
use Faker\Generator;

final class FixtureHelper
{
    final public const DEFAULT_PASSWORD = 'Qwerty123';

    private static ?Generator $faker = null;

    public static function getFaker(): Generator
    {
        if (null === self::$faker) {
            self::$faker = Factory::create('uk_UA');
            self::$faker->seed(12345);
        }

        return self::$faker;
    }

    private function __construct()
    {
    }
}
