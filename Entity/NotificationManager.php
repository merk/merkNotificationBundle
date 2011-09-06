<?php
namespace merk\NotificationBundle\Entity;

use Doctrine\ORM\EntityManager;
use merk\NotificationBundle\Model\NotificationManager as BaseNotificationManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationManager extends BaseNotificationManager
{
    protected $dispatcher;
    protected $em;
    protected $repository;
    protected $notifier;

    public function __construct(EntityManager $em, EventDispatcher $dispatcher, $notificationClass)
    {
        $this->em = $em;
        parent::__construct($dispatcher, $notificationClass);
    }
}