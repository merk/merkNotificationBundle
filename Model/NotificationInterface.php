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

interface NotificationInterface
{
    public function getUser();
    public function setUser(UserInterface $user);

    public function getSentAt();
    public function getCreatedAt();
    public function markSent();

    public function getMethod();
    public function setMethod($method);

    /**
     * Returns the notification event that triggered this
     * notification to be sent.
     *
     * @return NotificationEventInterface
     */
    public function getEvent();
    public function setEvent(NotificationEventInterface $event);

    /**
     * Returns the subject for the notification.
     *
     * Some agents will ignore this subject (such as
     * SMS, which has no subject).
     *
     * @return string
     */
    public function getSubject();
    public function setSubject($subject);

    /**
     * Returns the message body of the notification.
     *
     * @return string
     */
    public function getMessage();
    public function setMessage($message);

    /**
     * Returns the name of the recipient used for the
     * notification.
     *
     * @return string
     */
    public function getRecipientName();
    public function setRecipientName($recipientName);

    /**
     * Returns the contact information used to send the
     * notification. For example, for email notifications,
     * this will be an email address, and for SMS notifications
     * this will be a phone number that can recieve SMS messages.
     *
     * @return string
     */
    public function getRecipientData();
    public function setRecipientData($recipientData);
}