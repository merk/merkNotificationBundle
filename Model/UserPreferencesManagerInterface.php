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

/**
 * Defines the UserPreferencesManager interface.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface UserPreferencesManagerInterface
{
    /**
     * Creates a new UserPreferences object.
     *
     * @return UserPreferencesInterface
     */
    public function create();

    /**
     * Marks the preferences object for update and flushes
     * to to persistent storage.
     *
     * @param UserPreferencesInterface $preferences
     * @param bool $flush
     */
    public function update(UserPreferencesInterface $preferences, $flush = true);

    /**
     * Finds a UserPreferences object for the given User.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return UserPreferencesInterface
     */
    public function findByUser(UserInterface $user);
}