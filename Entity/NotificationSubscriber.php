<?php
namespace merk\NotificationBundle\Entity;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;

use merk\NotificationBundle\Metadata\Driver\AnnotationDriver;
use merk\NotificationBundle\Model\NotificationSubscriber as BaseNotificationSubscriber;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationSubscriber extends BaseNotificationSubscriber
{
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        
        foreach ($uow->getScheduledEntityInsertions() AS $entity) {
            $this->process($entity, 'insert');
        }

        foreach ($uow->getScheduledEntityUpdates() AS $entity) {
            $this->process($entity, 'update');
        }

        foreach ($uow->getScheduledEntityDeletions() AS $entity) {
            $this->process($entity, 'delete');
        }

        foreach ($uow->getScheduledCollectionDeletions() AS $col) {

        }

        foreach ($uow->getScheduledCollectionUpdates() AS $col) {

        }
    }
}
