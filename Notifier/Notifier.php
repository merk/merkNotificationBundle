<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Notifier;

use merk\NotificationBundle\Model\NotificationManagerInterface;
use merk\NotificationBundle\Model\NotificationEventManagerInterface;
use merk\NotificationBundle\Model\UserPreferencesManagerInterface;
use merk\NotificationBundle\Sender\SenderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

/**
 * Notifier service.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class Notifier implements NotifierInterface
{
    /**
     * @var \merk\NotificationBundle\Model\NotificationEventManagerInterface
     */
    protected $notificationEventManager;

    /**
     * @var \merk\NotificationBundle\Model\NotificationManagerInterface
     */
    protected $notificationManager;

    /**
     * @var \merk\NotificationBundle\Model\FilterManagerInterface
     */
    protected $filterManager;

    /**
     * @var \merk\NotificationBundle\Sender\SenderInterface
     */
    protected $sender;

    /**
     * @param \merk\NotificationBundle\Model\NotificationEventManagerInterface $notificationEventManager
     * @param \merk\NotificationBundle\Model\FilterManagerInterface $filterManager
     * @param \merk\NotificationBundle\Model\NotificationManagerInterface $notificationManager
     * @param \merk\NotificationBundle\Sender\SenderInterface $sender
     */
    public function __construct(NotificationEventManagerInterface $notificationEventManager, \merk\NotificationBundle\Model\FilterManagerInterface $filterManager, NotificationManagerInterface $notificationManager, SenderInterface $sender)
    {
        $this->notificationEventManager = $notificationEventManager;
        $this->notificationManager = $notificationManager;
        $this->filterManager = $filterManager;
        $this->sender = $sender;
    }

    /**
     * Triggers notifications for a specific notification event.
     *
     * @param string $key
     * @param mixed $subject
     * @param string $verb
     * @param \Symfony\Component\Security\Core\User\UserInterface $actor
     * @param \DateTime $createdAt
     */
    public function trigger($key, $subject, $verb, UserInterface $actor = null, DateTime $createdAt = null)
    {
        $event = $this->notificationEventManager->create($key, $subject, $verb, $actor, $createdAt);
        $filters = $this->filterManager->getFiltersForEvent($event);

        $notifications = $this->notificationManager->createForEvent($event, $filters);
        $this->sender->send($notifications);

        $this->notificationEventManager->update($event, false);
        $this->notificationManager->updateBulk($notifications);
    }
}