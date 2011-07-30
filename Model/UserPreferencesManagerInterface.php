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

/**
 * UserPreferencesManager base interface.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface UserPreferencesManagerInterface
{
    /**
     * Returns the User Preferences object for the supplied user. Creates
     * a new record if one does not exist. Uses the current user if no user
     * is supplied.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface|null $user
     * @return UserPreferencesInterface
     */
    function getPreferences(UserInterface $user = null);

    /**
     * Returns a UserPreferences object for the supplied user or null when
     * it doesnt exist.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return UserPreferences|null
     */
    function findByUser(UserInterface $user);

    /**
     * Persists the UserPreferences object to the database.
     *
     * @param UserPreferencesInterface $preferences
     */
    function update(UserPreferencesInterface $preferences);

    /**
     * Returns the class name for the UserPreference objects.
     *
     * @return string
     */
    function getClass();
}