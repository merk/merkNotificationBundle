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

    public function createNotification(array $data)
    {
        $notification = new Notification();
        // TODO:  move data into Notification

        return $notification;
    }

    public function trigger(PropertyMetadata $property, $model)
    {
        $data = array(); // TODO: this is built from the information provided by $property and $model
        $notification = $this->createNotification($data);
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