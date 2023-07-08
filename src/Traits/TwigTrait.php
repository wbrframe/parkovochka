<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Contracts\Service\Attribute\Required;
use Twig\Environment;

trait TwigTrait
{
    protected Environment $twig;

    #[Required]
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }
}
