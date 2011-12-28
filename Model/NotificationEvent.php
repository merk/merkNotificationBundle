<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

abstract class NotificationEvent implements NotificationEventInterface
{
    protected $notificationKey;
    protected $subject;
    protected $actor;
    protected $verb;
    protected $createdAt;

    /**
     * @param string $notificationKey
     * @param mixed $subject
     * @param string $verb
     * @param \Symfony\Component\Security\Core\User\UserInterface $actor
     * @param \DateTime $createdAt
     */
    public function __construct($notificationKey, $subject, $verb, UserInterface $actor = null, DateTime $createdAt = null)
    {
        $this->notificationKey = $notificationKey;
        $this->verb            = $verb;
        $this->createdAt       = $createdAt ?: new DateTime;

        $this->setActor($actor);
        $this->setSubject($subject);
    }

    /**
     * Sets the actor of this event.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $actor
     */
    abstract protected function setActor(UserInterface $actor = null);

    /**
     * Sets the subject of this event.
     *
     * @param mixed $subject
     */
    abstract protected function setSubject($subject);

    /**
     * Returns the subject of the event.
     *
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Returns the user that caused the event.
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Returns the verb describing the event.
     *
     * @return string
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * Returns when the event occurred.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Returns the event key.
     *
     * @return string
     */
    public function getNotificationKey()
    {
        return $this->notificationKey;
    }

}
