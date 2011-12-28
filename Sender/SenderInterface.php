<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Sender;

use merk\NotificationBundle\Model\NotificationEventInterface;

/**
 * An interface to describe a service that is able to send
 * an array of notifications to their given agents.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface SenderInterface
{
    /**
     * Returns an array of all available agents
     * that can be used to send a notification.
     *
     * @return array
     */
    public function getAgentAliases();

    /**
     * Sorts the array of notifications by notification method
     * and sends each in bulk to the appropriate agent for sending.
     *
     * @param array $notifications
     */
    public function send(array $notifications);
}