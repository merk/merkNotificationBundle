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
use merk\NotificationBundle\Model\UserPreferencesInterface;
use merk\NotificationBundle\Model\UserPreferencesManager as BaseUserPreferencesManager;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Doctrine ORM implementation of the UserPreferencesManager class.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class UserPreferencesManager extends BaseUserPreferencesManager
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

    public function findByUser(UserInterface $user)
    {
        $qb = $this->repository->createQueryBuilder('up');
        $qb->andWhere('up.user = :user');
        $qb->setParameter('user', $user);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function update(UserPreferencesInterface $preferences, $flush = true)
    {
        $this->em->persist($preferences);

        if ($flush) {
            $this->em->flush();
        }
    }
}