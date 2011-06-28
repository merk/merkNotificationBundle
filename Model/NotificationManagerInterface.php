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
 * NotificationManager base interface.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface NotificationManagerInterface
{
    /**
     * Adds a new notification for the provided User.
     *
     * @param UserInterface $user
     * @param NotificationInterface $notification
     * @return void
     */
    function addNotification(NotificationInterface $notification);

    /**
     * Gets all notifications for the provided User.
     *
     * @param UserInterface $user
     * @return NotificationInterface[]
     */
    function getNotifications(UserInterface $user);

    /**
     * Gets a single notification by the supplied Id.
     *
     * @param mixed $id
     * @return NotificationInterface|null
     */
    function getNotification($id);

    function createNotification(UserInterface $user);
    function getClass();
}
