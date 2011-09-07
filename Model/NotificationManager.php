<?php
namespace merk\NotificationBundle\Model;

use merk\NotificationBundle\Metadata\PropertyMetadata;
use merk\NotificationBundle\Model\NotificationManagerInterface;
use merk\NotificationBundle\Model\NotificationInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationManager implements NotificationManagerInterface
{
    protected $notificationClass;
    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher, $notificationClass)
    {
        $this->dispatcher = $dispatcher;
        $this->notificationClass = $notificationClass;
    }

    public function getNotificationClass()
    {
        return $this->class;
    }

    public function createNotification()
    {
        return new $this->notificationClass;

        return $notification;
    }

    public function dispatch(NotificationInterface $notification)
    {
        $this->dispatcher->dispatch('merk_notification.notification_event', $notification);
    }

    public function trigger(PropertyMetadata $property, $model)
    {
        $notification = $this->createNotification();
        $property->bindToNotification($notification, $model);
        $this->dispatch($notification);
        $this->persistNotification($notification);
    }

    protected function persistNotification($notification)
    {
        return null;
    }
}