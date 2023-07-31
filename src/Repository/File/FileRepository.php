<?php

declare(strict_types=1);

namespace App\Repository\File;

use App\Entity\File\File;
use App\Exception\Http\FileNotFoundHttpException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fresh\DateTime\DateTimeCloner;

class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, File::class);
    }

    public function findOneById(string $id): ?File
    {
        $qb = $this->createQueryBuilder('f');

        /** @var File|null $result */
        $result = $qb
            ->where($qb->expr()->eq('f.id', ':id'))
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $result;
    }

    public function getOneById(string $id): File
    {
        $result = $this->findOneById($id);

        if (!$result instanceof File) {
            throw new FileNotFoundHttpException($id);
        }

        return $result;
    }

    public function findOrphans(\DateTime $dateTime, string $modify = '-10 minutes'): array
    {
        $expiredTime = DateTimeCloner::cloneIntoDateTime($dateTime);
        $expiredTime->modify($modify);

        $qb = $this->createQueryBuilder('f');

        /** @var array $result */
        $result = $qb
            ->leftJoin('f.relation', 'r')
            ->where($qb->expr()->isNull('r.id'))
            ->andWhere($qb->expr()->lte('f.updatedAt', ':expired_time'))
            ->setParameter('expired_time', $expiredTime)
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }
}
