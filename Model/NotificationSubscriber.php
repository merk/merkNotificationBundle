<?php
namespace merk\NotificationBundle\Model;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;

use merk\NotificationBundle\Metadata\Driver\AnnotationDriver;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
abstract class NotificationSubscriber implements EventSubscriber
{
    protected $container;
    protected $driver;

    public function __construct($container)
    {
        $this->container = $container;
        $this->driver = new AnnotationDriver(new AnnotationReader());
    }

    public function getSubscribedEvents()
    {
        return array('onFlush');
    }

    protected function process($model, $action = null)
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
