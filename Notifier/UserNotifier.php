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
use merk\NotificationBundle\Model\UserPreferencesManagerInterface;
use \InvalidArgumentException;

/**
 * UserNotifier. Sends notification messages to users for specified
 * actions. Should take into account user specified preferences
 * regarding how they are to be notified.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class UserNotifier implements UserNotifierInterface
{
    protected $notifiers = array();
    protected $userPreferencesManager;

    public function __construct(array $notifiers, UserPreferencesManagerInterface $userPreferencesManager)
    {
        //var_dump($notifiers); die;
        foreach ($notifiers as $alias => $notifier) {
            if (!$notifier instanceof NotifierInterface) {
                throw new InvalidArgumentException(sprintf(
                    "Notifier of class (%s) with alias (%s) passed does not implement NotifierInterface", get_class($notifier), $alias
                ));
            }

            $this->notifiers[$alias] = $notifier;
        }

        $this->userPreferencesManager = $userPreferencesManager;
    }

    /**
     * Returns all available aliases for configured notifiers.
     *
     * @return array
     */
    public function getNotifierOptions()
    {
        return array_combine(array_keys($this->notifiers), array_keys($this->notifiers));
    }

    /**
     * Notify the target user that there has been an Action
     * created.
     *
     * @param ActionInterface
     */
    public function send(ActionInterface $action)
    {
        $prefs = $this->userPreferencesManager->findByUser($action->getTarget());

        foreach ($prefs->getNotificationMethods() AS $pref) {
            $this->notifiers[$pref]->notify($action);
        }
    }
}