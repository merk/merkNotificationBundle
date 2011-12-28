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
use merk\NotificationBundle\Model\FilterManager as BaseFilterManager;
use merk\NotificationBundle\Model\NotificationEventInterface;

/**
 * Doctrine ORM implementation of the FilterManager class.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class FilterManager extends BaseFilterManager
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

    public function create()
    {
        $class = $this->class;

        return new $class;
    }

    public function getFiltersForEvent(NotificationEventInterface $event)
    {
        $qb = $this->repository->createQueryBuilder('f')
            ->select(array('f', 'up', 'u'))
            ->leftJoin('f.userPreferences', 'up')
            ->leftJoin('up.user', 'u')
            ->andWhere('f.notificationKey = :key');

        return $qb->getQuery()->execute(array(
            'key' => $event->getNotificationKey()
        ));
    }
}