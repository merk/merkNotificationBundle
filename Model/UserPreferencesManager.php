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

/**
 * Base UserPreferencesManager
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
abstract class UserPreferencesManager implements UserPreferencesManagerInterface
{
    /**
     * Class to use when initialising a new UserPreferences object.
     *
     * @var string
     */
    protected $class;

    /**
     * The default sending method to be used when sending notifications.
     *
     * @var string
     */
    protected $defaultMethod;

    /**
     * Creates a new UserPreferences object.
     *
     * @return UserPreferencesInterface
     */
    public function create()
    {
        $class = $this->class;
        $userPreferences = new $class;
        $userPreferences->setMethod($this->defaultMethod);

        return $userPreferences;
    }
}