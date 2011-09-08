<?php
namespace merk\NotificationBundle\EventListener;

use merk\NotificationBundle\Model\NotificationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationListener
{
    public function onNotification(NotificationInterface $notification)
    {

    }
}
