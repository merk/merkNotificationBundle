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

/**
 * Base User Preferences interface.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface UserPreferencesInterface
{
    /**
     * Returns the service aliases for the user specified notification
     * methods.
     *
     * @return array
     */
    function getNotificationMethods();

    /**
     * Sets the service aliases for the user specified notification
     * methods.
     *
     * @param array $methods
     * @return void
     */
    function setNotificationMethods(array $methods);
}