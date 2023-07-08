<?php

declare(strict_types=1);

namespace App\Validator\Constraints\Geo;

use Symfony\Component\Validator\Constraints\Range;

#[\Attribute]
class ValidLatitude extends Range
{
    public const MAX_LATITUDE = 90;
    public const MIN_LATITUDE = -90;

    public function __construct(array $options = null)
    {
        $this->max = self::MAX_LATITUDE;
        $this->min = self::MIN_LATITUDE;
        $this->maxMessage = 'latitude_should_be_less_than_or_equal';
        $this->minMessage = 'latitude_is_greater_than_or_equal';

        parent::__construct($options);
    }
}
