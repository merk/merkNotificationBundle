<?php
namespace merk\NotificationBundle\Entity;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use merk\NotificationBundle\Metadata\Driver\AnnotationDriver;
use merk\NotificationBundle\Model\NotificationSubscriber as BaseNotificationSubscriber;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationSubscriber extends BaseNotificationSubscriber
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->process($args->getEntity());
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->process($args->getEntity());
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->process($args->getEntity());
    }
}
