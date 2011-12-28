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

abstract class Notification implements NotificationInterface
{
    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface
     */
    protected $user;

    protected $event;

    /**
     * The method used for this notification.
     *
     * @var string
     */
    protected $method;

    /**
     * When the notification was created.
     *
     * @var \DateTime
     */
    protected $createdAt;

    protected $sentAt;

    /**
     * The message sent to the user.
     *
     * @var string
     */
    protected $message;

    protected $subject;

    protected $recipientName;
    protected $recipientData;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setEvent(NotificationEventInterface $event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setRecipientData($recipientData)
    {
        $this->recipientData = $recipientData;
    }

    public function getRecipientData()
    {
        return $this->recipientData;
    }

    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;
    }

    public function getRecipientName()
    {
        return $this->recipientName;
    }


    public function getSentAt()
    {
        return $this->sentAt;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function markSent()
    {
        $this->sentAt = new \DateTime();
    }
}