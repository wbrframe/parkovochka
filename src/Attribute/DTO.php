<?php

declare(strict_types=1);

namespace App\Attribute;

use App\DTO\DtoInterface;
use App\Exception\InvalidArgumentException;

#[\Attribute(\Attribute::TARGET_CLASS)]
class DTO
{
    private const DTO_SUFFIX = 'Dto';

    private string $class;

    public function __construct(string $class)
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Class %s does not exist.', $class));
        }

        if (!is_subclass_of($class, DtoInterface::class)) {
            throw new InvalidArgumentException(sprintf('Class %s does not implement %s interface.', $class, DtoInterface::class));
        }

        if (self::DTO_SUFFIX !== mb_substr($class, -3)) {
            throw new InvalidArgumentException(sprintf('Class name %s must be suffixed with "%s".', $class, self::DTO_SUFFIX));
        }

        $this->class = $class;
    }

    public function getClass(): string
    {
        return $this->class;
    }
}
