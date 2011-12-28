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
 * UserPreferences interface
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface UserPreferencesInterface
{
    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser();

    /**
     * Adds a notification filter for the specific user.
     *
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter);

    /**
     * Removes the supplied filter from the user's preferences.
     *
     * @param FilterInterface $filter
     */
    public function removeFilter(FilterInterface $filter);

    /**
     * Returns a collection of filters for the user.
     *
     * @return array|\Doctrine\Common\Collection\Collection
     */
    public function getFilters();

    /**
     * Returns the default method used to notify the user if
     * the filter doesnt specify one.
     *
     * @return string
     */
    public function getDefaultMethod();

    /**
     * Sets the default method used to notify a user if the
     * filter doesnt specify one.
     *
     * @param string $defaultMethod
     */
    public function setDefaultMethod($defaultMethod);
}