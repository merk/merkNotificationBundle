<?php
namespace merk\NotificationBundle\EventDispatcher;

use merk\NotificationBundle\Metadata\PropertyMetadata;
use merk\NotificationBundle\Model\NotificationInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
interface NotificationDispatcherInterface
{
    public function dispatch(NotificationInterface $notification);

    /**
     * Trigger a notification event based on the instructions in the metadata and the values in the $model
     * 
     * @param merk\NotificationBundle\Metadata\PropertyMetadata $property
     * @param $model
     */
    public function trigger(PropertyMetadata $property, $model);

    /**
     * Returns the class name for an Action
     *
     * @return string
     */
    function getNotificationClass();
}
