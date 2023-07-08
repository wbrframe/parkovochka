<?php

declare(strict_types=1);

namespace App\Validator\Constraints\Geo;

use Symfony\Component\Validator\Constraints\Range;

#[\Attribute]
class ValidLongitude extends Range
{
    public const MAX_LONGITUDE = 180;
    public const MIN_LONGITUDE = -180;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options = null)
    {
        $this->max = self::MAX_LONGITUDE;
        $this->min = self::MIN_LONGITUDE;
        $this->maxMessage = 'longitude_should_be_less_than_or_equal';
        $this->minMessage = 'longitude_should_be_greater_than_or_equal';

        parent::__construct($options);
    }
}
