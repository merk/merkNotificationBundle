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
 * Base Action interface.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
interface ActionInterface
{
    /**
     * Returns the User the action belongs to.
     *
     * @return UserInterface
     */
    function getUser();

    /**
     * Sets the action message.
     *
     * @return string
     */
    function getMessage();

    /**
     * Sets the action message.
     *
     * @param string $message
     * @return void
     */
    function setMessage($message);

    /**
     * Marks the action read.
     *
     * @return void
     */
    function markRead();

    /**
     * Marks the action unread.
     *
     * @return void
     */
    function markUnread();

    /**
     * Returns when the action was read.
     *
     * @return DateTime
     */
    function getReadAt();

    /**
     * Returns the date the action was created.
     *
     * @return DateTime
     */
    function getCreatedAt();

    /**
     * Returns the route to direct to.
     *
     * @return string
     */
    function getRouteName();

    /**
     * Returns the routing parameters to be passed to the route.
     *
     * @return array
     */
    function getRouteParams();
}