<?php
namespace merk\NotificationBundle\Model;

use merk\NotificationBundle\Metadata\PropertyMetadata;
use merk\NotificationBundle\Model\Notification;
use merk\NotificationBundle\Model\NotificationManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationManager implements NotificationManagerInterface
{
    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function createNotification()
    {
        return new Notification();
    }

    public function trigger(PropertyMetadata $property, $model)
    {
        $notification = $this->createNotification();
        $this->persistNotification($notification);
    }

    public function getClass()
    {
        return null;
    }

    protected function persistNotification($notification)
    {
        return null;
    }
}