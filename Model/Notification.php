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

use Symfony\Component\EventDispatcher\Event;
use \DateTime;

/**
 * @author Tim Nagel <tim@nagel.com.au>
 * @author Richard D Shank <develop@zestic.com>
 */
class Notification extends Event implements NotificationInterface
{
    protected $actor;
    protected $attributes;
    protected $createdAt;
    protected $message;
    protected $object;
    protected $readAt;
    protected $routeName;
    protected $routeParams;
    protected $target;
    protected $verb;

    public function __construct(array $data = array())
    {
        $this->createdAt = new DateTime();
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

    public function getObject()
    {
        return $this->object;
    }

    public function setObject($object)
    {
        $this->object = $object;
    }

    public function getVerb()
    {
        return $this->verb;
    }

    public function setVerb($verb)
    {
        $this->verb = $verb;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getActor()
    {
        return $this->actor;
    }

    public function setActor($actor)
    {
        $this->actor = $actor;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
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

    public function addAttribute($attribute)
    {
        $this->attributes[] = $attribute;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}