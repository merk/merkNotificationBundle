<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Entity;

use Doctrine\ORM\EntityManager;
use merk\NotificationBundle\Model\NotificationEventInterface;
use merk\NotificationBundle\Model\NotificationEventManager as BaseNotificationEventManager;

/**
 * Doctrine ORM implementation of the NotificationEventManager class.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class NotificationEventManager extends BaseNotificationEventManager
{
    protected $em;
    protected $repository;
    protected $class;

    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;
    }

    /**
     * Persists and flushes the event to the persistent storage.
     *
     * @param \merk\NotificationBundle\Model\NotificationEventInterface $event
     * @param bool $flush
     */
    public function update(NotificationEventInterface $event, $flush = true)
    {
        $this->em->persist($event);

        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * Converts the subject object into a persistable string
     *
     * @param NotificationEvent $event
     */
    public function updateSubject(NotificationEvent $event)
    {
        $subject = $event->getSubject();

        if (null === $subject) {
            $event->setSubjectClass(null);
            $event->setSubjectIdentifiers(null);

            return;
        }

        $metadata = $this->em->getClassMetadata(get_class($subject));

        $event->setSubjectClass($metadata->name);
        $event->setSubjectIdentifiers($metadata->getIdentifierValues($subject));
    }

    /**
     * Converts the persisted subject string into a reference
     * object, or queries for the appropriate object.
     * @param NotificationEvent $event
     * @param bool $reference
     */
    public function replaceSubject(NotificationEvent $event, $reference = true)
    {
        if ($reference) {
            $subject = $this->em->getReference(
                $event->getSubjectClass(),
                $event->getSubjectIdentifiers()
            );
        } else {
            $subject = $this->em->find(
                $event->getSubject(),
                $event->getSubjectIdentifiers()
            );
        }

        $event->setSubject($subject);
    }
}