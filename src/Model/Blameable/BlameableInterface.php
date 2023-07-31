<?php

declare(strict_types=1);

namespace App\Model\Blameable;

use App\Entity\Admin\Admin;

interface BlameableInterface
{
    public function getUpdatedBy(): ?Admin;
    public function setUpdatedBy(Admin $admin = null);
    public function getCreatedBy(): ?Admin;
    public function setCreatedBy(Admin $admin = null);
}
