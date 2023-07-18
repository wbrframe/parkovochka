<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use App\Model\Geo\Coordinate;
use CrEOF\Geo\WKB\Parser as BinaryParser;
use CrEOF\Geo\WKT\Parser as StringParser;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Jsor\Doctrine\PostGIS\Types\GeometryType as BaseGeometryType;

class GeometryType extends BaseGeometryType
{
    /**
     * @param array<int, string>|null $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Coordinate
    {
        if (null === $value) {
            return null;
        }

        if (ctype_alpha($value[0])) {
            $parser = new StringParser($value); // @phpstan-ignore-line
        } else {
            $parser = new BinaryParser($value); // @phpstan-ignore-line
        }

        $value = $parser->parse();

        return new Coordinate($value['value'][0], $value['value'][1], $value['srid']);
    }
}
