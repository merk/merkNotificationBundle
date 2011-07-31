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
 * Standalone UserPreferences interface.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface StandaloneUserPreferencesInterface extends UserPreferencesInterface
{
    /**
     * Returns the User the notification belongs to.
     *
     * @return UserInterface
     */
    function getUser();

    /**
     * Returns the last time the user preferences object
     * was updated.
     *
     * @return DateTime
     */
    function getLastUpdated();

    /**
     * Updates the lastUpdated property.
     *
     * @return void
     */
    function markUpdated();
}