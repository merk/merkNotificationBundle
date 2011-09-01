<?php
namespace merk\NotificationBundle\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use merk\NotificationBundle\Annotation\Notify;
use merk\NotificationBundle\Metadata\ClassMetadata;
use Metadata\Driver\DriverInterface;
use \ReflectionClass;
use \ReflectionMethod;

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
        $metadata = new ClassMetadata($reflection->getName());

        return $metadata;
    }
}