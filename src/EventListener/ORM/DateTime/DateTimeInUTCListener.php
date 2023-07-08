<?php

declare(strict_types=1);

namespace App\EventListener\ORM\DateTime;

use App\Util\DateTimeZoneHelper;
use Doctrine\ORM\Event\PreFlushEventArgs;

final readonly class DateTimeInUTCListener
{
    public function __construct(private DateTimeZoneHelper $dateTimeTimezoneHelper)
    {
    }

    public function preFlush(PreFlushEventArgs $eventArgs): void
    {
        $em = $eventArgs->getObjectManager();

        $uow = $em->getUnitOfWork();
        $uow->computeChangeSets();

        $entities = array_merge($uow->getScheduledEntityInsertions(), $uow->getScheduledEntityUpdates());
        foreach ($entities as $entity) {
            $changeSet = $uow->getEntityChangeSet($entity);
            foreach ($changeSet as $columnName => $values) {
                $newValue = $values[1];
                if (!$newValue instanceof \DateTimeInterface) {
                    continue;
                }

                if (!$this->dateTimeTimezoneHelper->isUTC($newValue)) {
                    throw new \RuntimeException(sprintf('Date field when saving in DB must be in UTC, but for %s:%s is %s', $entity::class, $columnName, $newValue->getTimezone()->getName()));
                }
            }
        }
    }
}
