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

abstract class NotificationEventManager implements NotificationEventManagerInterface
{
    protected $class;

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
    public function create($key, $subject, $verb, UserInterface $actor = null, DateTime $createdAt = null)
    {
        $class = $this->class;

        return new $class($key, $subject, $verb, $actor);
    }
}