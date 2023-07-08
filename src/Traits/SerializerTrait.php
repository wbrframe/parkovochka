<?php

declare(strict_types=1);

namespace App\Traits;

use App\Serializer\Serializer;
use Symfony\Contracts\Service\Attribute\Required;

trait SerializerTrait
{
    protected Serializer $serializer;

    #[Required]
    public function setSerializer(Serializer $serializer): void
    {
        $this->serializer = $serializer;
    }
}
