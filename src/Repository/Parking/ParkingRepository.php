<?php

declare(strict_types=1);

namespace App\Repository\Parking;

use App\Entity\Parking\Parking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ParkingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Parking::class);
    }

    public function iterable(): iterable
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->getQuery()
            ->toIterable();
    }
}
