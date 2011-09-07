<?php
namespace merk\NotificationBundle\Document;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ODM\MongoDB\Event\OnFlushEventArgs;

use merk\NotificationBundle\Metadata\Driver\AnnotationDriver;
use merk\NotificationBundle\Model\NotificationSubscriber as BaseNotificationSubscriber;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationSubscriber extends BaseNotificationSubscriber
{
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $dm = $eventArgs->getDocumentManager();
        $uow = $dm->getUnitOfWork();
        
        foreach ($uow->getScheduledDocumentInsertions() AS $document) {
            $this->process($document, 'insert');
        }

        foreach ($uow->getScheduledEntityUpdates() AS $document) {
            $this->process($document, 'update');
        }

        foreach ($uow->getScheduledEntityDeletions() AS $document) {
            $this->process($document, 'delete');
        }

        foreach ($uow->getScheduledCollectionDeletions() AS $col) {

        }

        foreach ($uow->getScheduledCollectionUpdates() AS $col) {

        }
    }
}
