<?php
namespace merk\NotificationBundle\EventDispatcher;

use merk\NotificationBundle\EventDispatcher\NotificationDispatcherInterface;
use merk\NotificationBundle\Metadata\PropertyMetadata;
use merk\NotificationBundle\Model\NotificationInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationDispatcher implements NotificationDispatcherInterface
{
    protected $dependencies;
    protected $dispatcher;
    protected $notificationClass;
    protected $notifications = array();

    public function __construct(EventDispatcher $dispatcher, $notificationClass)
    {
        $this->dispatcher = $dispatcher;
        $this->notificationClass = $notificationClass;
    }

    public function getNotificationClass()
    {
        return $this->notificationClass;
    }

    public function createNotification()
    {
        return new $this->notificationClass;
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
    }
}