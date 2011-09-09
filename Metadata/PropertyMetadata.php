<?php
namespace merk\NotificationBundle\Metadata;

use merk\NotificationBundle\Metadata\ClassMetadata;
use Metadata\PropertyMetadata as BasePropertyMetadata;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
class PropertyMetadata extends BasePropertyMetadata
{
    public $actor;
    public $object;
    public $target;
    public $trigger;
    public $verb;
    protected $classMetadata;
    protected $reflectionClass;

    public function __construct($class, $name, ClassMetadata $classMetadata)
    {
        $this->classMetadata = $classMetadata;
        parent::__construct($class, $name);
    }

    public function bindToNotification($notification, $model)
    {
        $this->setProperty($notification, 'verb', $this->verb);

        foreach (array('actor', 'object', 'target') as $attribute) {
            if ($propertyName = $this->$attribute ) {
                if ($propertyName == 'this') {
                    $value = $model;
                } else {
                    $value = $this->classMetadata->getValue($model, $propertyName);
                }
                if ($value) {
                    $this->setProperty($notification, $attribute, $value);
                }
            }
        }
    }

    protected function setProperty(&$notification, $attribute, $value)
    {
        $reflectionClass = new \ReflectionClass($notification);

        $property = $reflectionClass->getProperty($attribute);
        $property->setAccessible(true);
        $property->setValue($notification, $value);
    }
}
