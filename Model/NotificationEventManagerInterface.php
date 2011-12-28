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

interface NotificationEventManagerInterface
{
    /**
     * Creates a new Event.
     *
     * @param string $key
     * @param mixed $subject
     * @param string $verb
     * @param \Symfony\Component\Security\Core\User\UserInterface $actor
     * @param \DateTime $createdAt
     *
     * @return NotificationEventInterface
     */
    public function create($key, $subject, $verb, UserInterface $actor = null, DateTime $createdAt = null);

    /**
     * Persists and flushes the event to the persistent storage.
     *
     * @param NotificationEventInterface $event
     * @param bool $flush
     */
    public function update(NotificationEventInterface $event, $flush = true);
}