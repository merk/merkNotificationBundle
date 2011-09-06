<?php
namespace merk\NotificationBundle\EventListener;

use merk\NotificationBundle\Model\NotificationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationListener implements EventSubscriberInterface
{
    static public function getSubscribedEvents()
    {
        return array(
            'merk_notification.notification' => 'onNotification',
        );
    }

    public function onNotification(NotifcationInterface $action)
    {
        $a = 0;
    }
}
