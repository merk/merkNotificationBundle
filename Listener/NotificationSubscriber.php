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
    protected $container;
    protected $notificationManager;
    protected $driver;

    public function __construct($container)
    {
        $this->container = $container;
        //$this->notificationManager = $container->get('merk_notification.notification_manager');
        $this->driver = new AnnotationDriver(new AnnotationReader());

    }

    public function getSubscribedEvents()
    {
        return array('onFlush');
    }

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

    protected function process($model, $action)
    {
        if (!$metadata = $this->driver->loadMetadataForClass(new \ReflectionClass($model))) {
            return;
        }
        foreach ($metadata->propertyMetadata as $property) {
            if ($this->triggerNotification($property->trigger, $property->getValue($model))) {
                $this->container->get('merk_notification.notification_manager')->trigger($property, $model);
            }
        }
    }

    protected function triggerNotification($trigger, $value)
    {
        return eval("return \$value == " . $trigger . ';');
    }
}
