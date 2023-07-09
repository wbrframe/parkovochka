<?php

declare(strict_types=1);

namespace App\Traits;

use App\Validator\EntityValidator;
use Symfony\Contracts\Service\Attribute\Required;

trait EntityValidatorTrait
{
    protected EntityValidator $entityValidator;

    #[Required]
    public function setEntityValidator(EntityValidator $entityValidator): void
    {
        $this->entityValidator = $entityValidator;
    }
}
