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

use merk\NotificationBundle\Model\NotificationEvent AS BaseNotificationEvent;

/**
 * Doctrine ORM implementation of the NotificationEvent class.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
abstract class NotificationEvent extends BaseNotificationEvent
{
    /**
     * A temporary subject object variable. Used by Doctrine ORM listener
     * to conver it into a FQCN/identifiers.
     *
     * @var mixed
     */
    protected $subject;

    /**
     * The fully qualified class of the subject object.
     *
     * @var string
     */
    protected $subjectClass;

    /**
     * An array of identifiers used to identify the subject object.
     *
     * @var array
     */
    protected $subjectIdentifiers;

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param string $subjectClass
     */
    public function setSubjectClass($subjectClass)
    {
        $this->subjectClass = $subjectClass;
    }

    /**
     * @return string
     */
    public function getSubjectClass()
    {
        return $this->subjectClass;
    }

    /**
     * @param array $subjectIdentifiers
     */
    public function setSubjectIdentifiers(array $subjectIdentifiers = null)
    {
        $this->subjectIdentifiers = $subjectIdentifiers;
    }

    /**
     * @return array
     */
    public function getSubjectIdentifiers()
    {
        return $this->subjectIdentifiers;
    }
}