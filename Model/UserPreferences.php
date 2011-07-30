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

use Symfony\Component\Security\Core\User\UserInterface;
use \DateTime;

abstract class UserPreferences implements UserPreferencesInterface
{
    protected $user;
    protected $lastUpdated;
    protected $notificationMethod;

    /**
     * Returns the User the notification belongs to.
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user the notification belongs to.
     *
     * @param UserInterface $user
     * @return void
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Returns the service alias for the user specified notification
     * method.
     *
     * @return string
     */
    public function getNotificationMethod()
    {
        return $this->notificationMethod;
    }

    /**
     * Sets the service alias for the user specified notification
     * method.
     *
     * @param string $method
     * @return void
     */
    public function setNotificationMethod($method)
    {
        $this->notificationMethod = $method;
    }

    /**
     * Returns the last time the user preferences object
     * was updated.
     *
     * @return DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Updates the last time the user preferences object
     * was updated.
     *
     * @param DateTime
     */
    public function updateLastUpdated()
    {
        $this->lastUpdated = new DateTime();
    }
}