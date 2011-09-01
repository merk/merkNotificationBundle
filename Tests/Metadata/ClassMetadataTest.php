<?php
namespace merk\NotificationBundle\Tests\Metadata;

use merk\NotificationBundle\Metadata\ClassMetadata;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
class ClassMetadataTest extends \PHPUnit_Framework_TestCase
{
    public function testSerializeUnserialize()
    {

        $this->assertEquals($classMetadata, unserialize(serialize($classMetadata)));
    }
}