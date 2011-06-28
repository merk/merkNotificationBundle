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

use FOS\UserBundle\Model\UserInterface;
use \DateTime;

abstract class Notification implements NotificationInterface
{
    protected $readAt;
    protected $user;
    protected $message;
    protected $createdAt;

    public function __construct()
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

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}