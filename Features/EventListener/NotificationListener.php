<?php
namespace merk\NotificationBundle\Features\EventListener;

use merk\NotificationBundle\Model\NotificationInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationListener
{
    protected $notification;

    public function onNotification(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    public function getNotification()
    {
        return $this->notification;
    }
}
