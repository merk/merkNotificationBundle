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
use DateTime;

/**
 * Base User Preferences interface.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface UserPreferencesInterface
{
    /**
     * Returns the User the notification belongs to.
     *
     * @return UserInterface
     */
    function getUser();

    /**
     * Sets the user the notification belongs to.
     *
     * @param UserInterface $user
     * @return void
     */
    function setUser(UserInterface $user);

    /**
     * Returns the service alias for the user specified notification
     * method.
     *
     * @return string
     */
    function getNotificationMethod();

    /**
     * Sets the service alias for the user specified notification
     * method.
     *
     * @param string $method
     * @return void
     */
    function setNotificationMethod($method);

    /**
     * Returns the last time the user preferences object
     * was updated.
     *
     * @return DateTime
     */
    function getLastUpdated();
}