<?php

declare(strict_types=1);

namespace App\Security;

final class Role
{
    public const ANONYMOUS = 'ROLE_ANONYMOUS';
    public const USER = 'ROLE_USER';
    public const ADMIN = 'ROLE_ADMIN';
    public const APPLICATION_USER = 'ROLE_APPLICATION_USER';
}
