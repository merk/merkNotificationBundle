<?php

/**
 * This file is part of the NotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace merk\NotificationBundle\Entity;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use merk\NotificationBundle\Model\StandaloneUserPreferencesInterface;
use merk\NotificationBundle\Model\UserPreferencesInterface;
use merk\NotificationBundle\Model\UserPreferencesManager as BaseUserPreferencesManager;
use Symfony\Component\Security\Core\SecurityContextInterface;
use DateTime;

class UserPreferencesManager extends BaseUserPreferencesManager
{
    protected $em;
    protected $repository;
    protected $class;
    protected $securityContext;

    public function __construct(EntityManager $em, $class, SecurityContextInterface $securityContext)
    {
        $this->em              = $em;
        $this->repository      = $em->getRepository($class);
        $this->class           = $em->getClassMetadata($class)->name;
        $this->securityContext = $securityContext;
    }

    /**
     * Returns the User Preferences object for the supplied user. Creates
     * a new record if one does not exist. Uses the current user if no user
     * is supplied.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface|null $user
     * @return UserPreferencesInterface
     */
    public function getPreferences(UserInterface $user = null)
    {
        if (null === $user) {
            $user = $this->securityContext->getToken()->getUser();
        }

        $preferences = $this->findByUser($user);
        if (!$preferences) {
            $preferences = $this->createPreferences($user);
        }

        return $preferences;
    }

    /**
     * Returns a UserPreferences object for the supplied user or null when
     * it doesnt exist.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return UserPreferences|null
     */
    public function findByUser(UserInterface $user)
    {
        $qb = $this->repository->createQueryBuilder('up');
        $qb->where('up.user = :user');
        $qb->setParameter('user', $user);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Persists the UserPreferences object to the database.
     *
     * @param UserPreferencesInterface $preferences
     */
    public function update(UserPreferencesInterface $preferences)
    {
        if ($preferences instanceof StandaloneUserPreferencesInterface) {
            $preferences->markUpdated();
        }

        $this->em->persist($preferences);
        $this->em->flush();
    }

    /**
     * Returns the class name for the UserPreference objects.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}