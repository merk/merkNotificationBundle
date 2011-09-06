<?php
namespace merk\NotificationBundle\Model;

use merk\NotificationBundle\Metadata\PropertyMetadata;
use merk\NotificationBundle\Model\NotificationManagerInterface;
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

    public function createNotification(array $data)
    {
        $notification = new $this->notificationClass;

        return $notification;
    }

    public function trigger(PropertyMetadata $property, $model)
    {
        $notification = $this->createNotification($data);
        $this->persistNotification($notification);
    }

    protected function persistNotification($notification)
    {
        return null;
    }
}