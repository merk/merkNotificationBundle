<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Sender;

use merk\NotificationBundle\Model\NotificationEventInterface;
use merk\NotificationBundle\Model\UserPreferencesManagerInterface;
use merk\NotificationBundle\Sender\Agent\AgentInterface;

/**
 * Sender service.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class Sender implements SenderInterface
{
    /**
     * An array of sending agents. Key is the alias.
     *
     * @var array
     */
    protected $agents = array();

    /**
     * @param array $agents
     */
    public function __construct(array $agents)
    {
        foreach ($agents as $agent) {
            if (!$agent instanceof AgentInterface) {
                throw new \InvalidArgumentException(sprintf('Agent %s must implement AgentInterface', get_class($agent)));
            }
        }

        $this->agents = $agents;
    }

    /**
     * Returns an array of agent aliases that can be used to send
     * a notification.
     *
     * @return array
     */
    public function getAgentAliases()
    {
        return array_keys($this->agents);
    }

    /**
     * Gets an agent by its alias, or throws an exception when
     * that agent does not exist.
     *
     * @param string $alias
     * @return \merk\NotificationBundle\Sender\Agent\AgentInterface
     * @throws \InvalidArgumentException when the alias doesnt exist
     */
    protected function getAgent($alias)
    {
        if (!isset($this->agents[$alias])) {
            throw new \InvalidArgumentException(sprintf('Alias "%s" doesnt exist', $alias));
        }

        return $this->agents[$alias];
    }

    /**
     * Sorts the array of notifications by notification method
     * and sends each in bulk to the appropriate agent for sending.
     *
     * @param array $notifications
     */
    public function send(array $notifications)
    {
        $sorted = array();
        foreach ($notifications as $notification) {
            $sorted[$notification->getMethod()][] = $notification;
        }

        foreach ($sorted as $method => $notifications) {
            $this->getAgent($method)->sendBulk($notifications);
        }
    }
}