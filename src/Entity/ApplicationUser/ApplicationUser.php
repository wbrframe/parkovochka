<?php

declare(strict_types=1);

namespace App\Entity\ApplicationUser;

use App\Entity\User\AbstractUser;
use App\Security\Role;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'application_users')]
class ApplicationUser extends AbstractUser
{
    public function getType(): string
    {
        return self::TYPE_APPLICATION_USER;
    }

    public function getRoles(): array
    {
        return [Role::APPLICATION_USER];
    }
}
