<?php
namespace merk\NotificationBundle\Features\EventListener;

use merk\NotificationBundle\Model\NotificationInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationListener
{
    protected $notifications = array();

    public function onNotification(NotificationInterface $notification)
    {
        $this->notifications[] = $notification;
    }

    public function getNotifications()
    {
        return $this->notifications;
    }
}
