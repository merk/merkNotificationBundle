<?php
namespace merk\NotificationBundle\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use merk\NotificationBundle\Annotation\Notify;
use merk\NotificationBundle\Metadata\ClassMetadata;
use merk\NotificationBundle\Metadata\PropertyMetadata;
use Metadata\Driver\DriverInterface;
use \ReflectionClass;
use \ReflectionProperty;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class AnnotationDriver implements DriverInterface
{
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function loadMetadataForClass(ReflectionClass $reflection)
    {
        $reflectionName = $reflection->getName();
        $metadata = null;

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED) as $property) {
            // check if the method was defined on this class
            if ($property->getDeclaringClass()->getName() !== $reflectionName) {
                continue;
            }

            $annotations = $this->reader->getPropertyAnnotations($property);

            if ($annotations) {
                foreach ($annotations as $annotation) {
                    if ($annotation instanceof Notify) {
                        $metadata = $metadata ? $metadata : new ClassMetadata($reflectionName);
                        $propertyMetadata = new PropertyMetadata($reflectionName, $property->getName(), $metadata);
                        $propertyMetadata->author = $annotation->author;
                        $propertyMetadata->object = $annotation->object;
                        $propertyMetadata->target = $annotation->target;
                        $propertyMetadata->trigger = $annotation->trigger;
                        $propertyMetadata->verb = $annotation->verb;

                        $metadata->addPropertyMetadata($propertyMetadata);
                    }
                }
            }
        }

        return $metadata;
    }
}