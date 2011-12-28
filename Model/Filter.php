<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Model;

/**
 * Base Filter class
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
abstract class Filter implements FilterInterface
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $notificationKey;

    /**
     * @var string
     */
    protected $recipientData;

    /**
     * @var string
     */
    protected $recipientName;

    /**
     * @var UserPreferencesInterface
     */
    protected $userPreferences;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getNotificationKey()
    {
        return $this->notificationKey;
    }

    /**
     * @param string $notificationKey
     */
    public function setNotificationKey($notificationKey)
    {
        $this->notificationKey = $notificationKey;
    }

    /**
     * @param UserPreferencesInterface|null $userPreferences
     */
    public function setUserPreferences(UserPreferencesInterface $userPreferences = null)
    {
        $this->userPreferences = $userPreferences;
    }

    /**
     * @return string
     */
    public function getRecipientData()
    {
        if ($this->recipientData) {
            return $this->recipientData;
        }

        if ($this->getUserPreferences()) {
            return $this->getUserPreferences()->getUser()->getEmail();
        }

        return null;
    }

    /**
     * @param string $recipientData
     */
    public function setRecipientData($recipientData)
    {
        $this->recipientData = $recipientData;
    }

    /**
     * @return null|string
     */
    public function getRecipientName()
    {
        if ($this->recipientName) {
            return $this->recipientName;
        }

        if ($this->getUserPreferences()) {
            return $this->getUserPreferences()->getUser()->getUsername();
        }

        return null;
    }

    /**
     * @param string $recipientName
     */
    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;
    }

    /**
     * @return UserPreferencesInterface
     */
    public function getUserPreferences()
    {
        return $this->userPreferences;
    }
}