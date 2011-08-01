<?php

/**
 * This file is part of the NotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace merk\NotificationBundle\Notifier;

use merk\NotificationBundle\Model\ActionInterface;

/**
 * Base UserNotifier interface. Sends notification messages
 * to users for specified actions. Should take into account user
 * specified preferences regarding how they are to be notified.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface UserNotifierInterface
{
    /**
     * Notify the target user that there has been an Action
     * created.
     *
     * @param ActionInterface
     * @return boolean
     */
    function send(ActionInterface $action);

    /**
     * Returns all available aliases for configured notifiers.
     *
     * @return array
     */
    function getNotifierOptions();
}