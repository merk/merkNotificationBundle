<?php

/**
 * This file is part of the NotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace merk\NotificationBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use \DateTime;

abstract class Action implements ActionInterface
{
    protected $readAt;
    protected $target;
    protected $actor;
    protected $message;
    protected $createdAt;
    protected $routeName;
    protected $routeParams;

    public function __construct(UserInterface $target, UserInterface $actor = null)
    {
        $this->createdAt = new DateTime();
        $this->target = $target;
        $this->actor = $actor;
    }

    public function markRead()
    {
        $this->readAt = new DateTime();
    }

    public function markUnread()
    {
        $this->readAt = null;
    }

    public function getReadAt()
    {
        return $this->readAt;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getActor()
    {
        return $this->actor;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setRoute($name, $params=array())
    {
        $this->routeName = $name;
        $this->routeParams = $params;
    }

    public function getRouteName()
    {
        return $this->routeName;
    }

    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
    }

    public function getRouteParams()
    {
        return explode(',', $this->routeParams);
    }

    public function setRouteParams(array $routeParams)
    {
        $this->routeParams = implode(',', $routeParams);
    }
}