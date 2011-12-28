<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Sender\Agent;

use merk\NotificationBundle\Model\NotificationInterface;

/**
 * A stub class for sending notifications via SMS.
 *
 * TODO: Implementation.. External PHP sms 'library'?
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class SMSAgent implements AgentInterface
{
    /**
     * Sends a single notification.
     *
     * @param \merk\NotificationBundle\Model\NotificationInterface $notification
     */
    public function send(NotificationInterface $notification)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Sends a group of notifications.
     *
     * @param array $notifications
     */
    public function sendBulk(array $notifications)
    {
        throw new \Exception('Not implemented');
    }
}