<?php
namespace merk\NotificationBundle\Model;

use merk\NotificationBundle\Metadata\PropertyMetadata;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
interface NotificationManagerInterface
{
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
