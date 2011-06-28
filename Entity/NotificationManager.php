<?php

/**
 * This file is part of the NotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace merk\NotificationBundle\Entity;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use merk\NotificationBundle\Model\NotificationInterface;
use merk\NotificationBundle\Model\NotificationManager as BaseNotificationManager;
use \DateTime;

class NotificationManager extends BaseNotificationManager
{
    protected $em;
    protected $repository;
    protected $class;

    public function __construct(EntityManager $em, $class)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository($class);
        $this->class      = $em->getClassMetadata($class)->name;
    }

    public function getNotification($id)
    {
        return $this->repository->find($id);
    }

    public function getNotifications(UserInterface $user)
    {
        return $this->repository->findBy(array('user' => $user));
    }

    public function addNotification(NotificationInterface $notification)
    {
        $this->em->persist($notification);
        $this->em->flush();
    }

    public function getClass()
    {
        return $this->class;
    }
}