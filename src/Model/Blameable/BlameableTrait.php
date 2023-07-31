<?php

declare(strict_types=1);

namespace App\Model\Blameable;

use App\Entity\Admin\Admin;
use Doctrine\ORM\Mapping as ORM;

trait BlameableTrait
{
    #[ORM\ManyToOne(targetEntity: Admin::class)]
    #[ORM\JoinColumn(name: 'created_by', nullable: true)]
    protected ?Admin $createdBy = null;

    #[ORM\ManyToOne(targetEntity: Admin::class)]
    #[ORM\JoinColumn(name: 'updated_by', nullable: true)]
    protected ?Admin $updatedBy = null;

    public function getCreatedBy(): ?Admin
    {
        return $this->createdBy;
    }

    public function setCreatedBy(Admin $admin = null): self
    {
        $this->createdBy = $admin;

        return $this;
    }

    public function getUpdatedBy(): ?Admin
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(Admin $admin = null): self
    {
        $this->updatedBy = $admin;

        return $this;
    }
}
