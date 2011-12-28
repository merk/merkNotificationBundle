<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Notifier;

use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

/**
 * Interface that the Notifier service implements.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface NotifierInterface
{
    /**
     * Triggers notifications for a specific notification event.
     *
     * @param string $key
     * @param mixed $subject
     * @param string $verb
     * @param \Symfony\Component\Security\Core\User\UserInterface $actor
     * @param \DateTime $createdAt
     */
    public function trigger($key, $subject, $verb, UserInterface $actor = null, DateTime $createdAt = null);
}