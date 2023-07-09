<?php

declare(strict_types=1);

namespace App\Traits;

use App\Request\DtoExtractor;
use Symfony\Contracts\Service\Attribute\Required;

trait DtoExtractorTrait
{
    protected DtoExtractor $dtoExtractor;

    #[Required]
    public function setDtoExtractor(DtoExtractor $dtoExtractor): void
    {
        $this->dtoExtractor = $dtoExtractor;
    }
}
