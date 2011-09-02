<?php

namespace merk\NotificationBundle\Tests\Metadata\Driver;

use Doctrine\Common\Annotations\AnnotationReader;

use merk\NotificationBundle\Metadata\Driver\AnnotationDriver;

class AnnotationDriverTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadMetadataFromClass()
    {
        $driver = new AnnotationDriver(new AnnotationReader());

        $metadata = $driver->loadMetadataForClass(new \ReflectionClass('merk\NotificationBundle\Tests\Fixture\Post'));
        $a = 0;
    }
}