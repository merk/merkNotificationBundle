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
interface ActionManagerInterface
{
    /**
     * Adds a new notification for the provided User.
     *
     * @param ActionInterface $notification
     * @return void
     */
    function addAction(ActionInterface $action);

    /**
     * Gets all notifications for the provided User.
     *
     * @param UserInterface $user
     * @return NotificationInterface[]
     */
    function getActions(UserInterface $user);

    /**
     * Gets a single notification by the supplied Id.
     *
     * @param mixed $id
     * @return NotificationInterface|null
     */
    function getAction($id);

    /**
     * Creates a new action for the provided user.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return ActionInterface
     */
    function createAction(UserInterface $user);

    /**
     * Returns the class name for an Action
     *
     * @return string
     */
    function getClass();
}
