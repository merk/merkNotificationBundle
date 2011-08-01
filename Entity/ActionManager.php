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
use merk\NotificationBundle\Model\ActionInterface;
use merk\NotificationBundle\Model\ActionManager as BaseActionManager;
use merk\NotificationBundle\Notifier\UserNotifierInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Doctrine ORM Notification Manager
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class ActionManager extends BaseActionManager
{
    protected $em;
    protected $repository;
    protected $class;
    protected $notifier;

    public function __construct(EntityManager $em, $class, UserNotifierInterface $notifier)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository($class);
        $this->class      = $em->getClassMetadata($class)->name;
        $this->notifier   = $notifier;
    }

    public function getAction($id)
    {
        return $this->repository->find($id);
    }

    public function getActions(UserInterface $user)
    {
        return $this->repository->findBy(array('user' => $user->getId()));
    }

    public function addAction(ActionInterface $action)
    {
        $this->em->persist($action);
        $this->em->flush();

        $this->notifier->send($action);
    }

    public function getClass()
    {
        return $this->class;
    }
}