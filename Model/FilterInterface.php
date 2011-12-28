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

interface FilterInterface
{
    public function setUserPreferences(UserPreferencesInterface $preferences = null);

    /**
     *
     * @return UserPreferencesInterface
     */
    public function getUserPreferences();

    public function getNotificationKey();
    public function getMethod();

    public function getRecipientName();
    public function getRecipientData();
}