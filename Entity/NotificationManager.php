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
    protected $class;
    protected $notifier;

    public function __construct(EntityManager $em, $class, EventDispatcher $dispatcher)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository($class);
        $this->class      = $em->getClassMetadata($class)->name;
        parent::__construct($dispatcher);
    }

    public function getNotificationClass()
    {
        return $this->class;
    }
}