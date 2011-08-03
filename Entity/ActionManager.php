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
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Doctrine ORM Notification Manager
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class ActionManager extends BaseActionManager
{
    protected $dispatcher;
    protected $em;
    protected $repository;
    protected $class;
    protected $notifier;

    public function __construct(EntityManager $em, $class, EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->em         = $em;
        $this->repository = $em->getRepository($class);
        $this->class      = $em->getClassMetadata($class)->name;
    }

    public function getAction($id)
    {
        return $this->repository->find($id);
    }

    public function getActions(UserInterface $user)
    {
        return $this->repository->findBy(array('user' => $user));
    }

    public function addAction(ActionInterface $action)
    {
        $this->em->persist($action);
        $this->em->flush();

        $this->dispatcher->dispatch('user.notification', $action);
    }

    public function getClass()
    {
        return $this->class;
    }
}