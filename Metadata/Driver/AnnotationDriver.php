<?php
namespace merk\NotificationBundle\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use merk\NotificationBundle\Annotation\Notify;
use merk\NotificationBundle\Metadata\ClassMetadata;
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
        $metadata = new ClassMetadata($reflectionName);

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED) as $property) {
            // check if the method was defined on this class
            if ($property->getDeclaringClass()->getName() !== $reflectionName) {
                continue;
            }

            $annotations = $this->reader->getPropertyAnnotations($property);

            if ($annotations) {
                $metadata->addPropteryMetadata($property);
            }
        }

        return $metadata;
    }
}