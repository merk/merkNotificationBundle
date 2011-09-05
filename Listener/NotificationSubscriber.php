<?php
namespace merk\NotificationBundle\Listener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;

use merk\NotificationBundle\Metadata\Driver\AnnotationDriver;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationSubscriber implements EventSubscriber
{
    protected $notificationManager;

    public function __construct($notificationManager = null)
    {
        $this->notificationManager = $notificationManager;
    }

    public function getSubscribedEvents()
    {
        return array('onFlush');
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $driver = new AnnotationDriver(new AnnotationReader());

        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        
        foreach ($uow->getScheduledEntityInsertions() AS $entity) {
            $metadata = $driver->loadMetadataForClass(new \ReflectionClass($entity));
            $a = 0;
        }

        foreach ($uow->getScheduledEntityUpdates() AS $entity) {

        }

        foreach ($uow->getScheduledEntityDeletions() AS $entity) {

        }

        foreach ($uow->getScheduledCollectionDeletions() AS $col) {

        }

        foreach ($uow->getScheduledCollectionUpdates() AS $col) {

        }

    }
}
