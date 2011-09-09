<?php
namespace merk\NotificationBundle\Metadata;

use merk\NotificationBundle\Metadata\PropertyMetadata;
use Metadata\ClassMetadata as BaseClassMetadata;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class ClassMetadata extends BaseClassMetadata
{
    public function getValue($obj, $propertyName)
    {
        $property = $this->reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

    public function setValue($obj, $propertyName, $value)
    {
        $property = $this->reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($obj, $value);
    }
}
