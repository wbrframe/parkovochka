<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function __construct(string $environment, bool $debug)
    {
        parent::__construct($environment, $debug);

        // Set default encoding for MB functions manually to prevent cases when it is missed in config
        mb_internal_encoding('UTF-8');

        // Set UTC timezone for all application dates
        date_default_timezone_set('UTC');
    }
}
