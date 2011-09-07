<?php
namespace merk\NotificationBundle\Document;

use Doctrine\ODM\MongoDB\DocumentManager;
use merk\NotificationBundle\Model\NotificationManager as BaseNotificationManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationManager extends BaseNotificationManager
{
    protected $dispatcher;
    protected $dm;
    protected $repository;
    protected $notifier;

    public function __construct(DocumentManager $dm, EventDispatcher $dispatcher, $notificationClass)
    {
        $this->dm = $dm;
        parent::__construct($dispatcher, $notificationClass);
    }
}