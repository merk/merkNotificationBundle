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
 * Base UserPreferences object.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
abstract class UserPreferences implements UserPreferencesInterface
{
    /**
     * @var \DateTime
     */
    protected $updatedAt;

    protected $filters;
    protected $user;
    protected $defaultMethod;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Adds a notification filter for the specific user.
     *
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters->add($filter);
        $filter->setUserPreferences($this);
    }

    /**
     * Removes the supplied filter from the user's preferences.
     *
     * @param FilterInterface $filter
     */
    public function removeFilter(FilterInterface $filter)
    {
        $this->filters->remove($filter);
        $filter->setUserPreferences(null);
    }

    /**
     * Returns a collection of filters for the user.
     *
     * @return array|\Doctrine\Common\Collection\Collection
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Sets the default method used to notify the user if the
     * filters do not specify a custom notification type.
     *
     * @param string $defaultMethod
     */
    public function setDefaultMethod($defaultMethod)
    {
        $this->defaultMethod = $defaultMethod;
    }

    /**
     * Sets the default method used to notify the user if the
     * filters do not specify a custom notification type.
     *
     * @return string
     */
    public function getDefaultMethod()
    {
        return $this->defaultMethod;
    }
}