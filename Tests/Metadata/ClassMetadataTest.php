<?php
namespace merk\NotificationBundle\Tests\Metadata;

use merk\NotificationBundle\Metadata\ClassMetadata;
use merk\NotificationBundle\Tests\Fixture\Post;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class ClassMetadataTest extends \PHPUnit_Framework_TestCase
{
    public function testSetValue()
    {
        $post = new Post;
        $classMetadata = new ClassMetadata($post);
        $name = 'This is the name';
        $classMetadata->setValue($post, 'name', $name);
        $this->assertSame($name, $post->getName());
    }

    public function testGetValue()
    {
        $post = new Post;
        $name = "What's in a name?";
        $post->setName($name);
        $classMetadata = new ClassMetadata($post);
        $this->assertSame($name, $classMetadata->getValue($post, 'name'));
    }
    
    public function testSerializeUnserialize()
    {
        $classMetadata = new ClassMetadata('merk\NotificationBundle\Features\Entity\Post');

        $this->assertEquals($classMetadata, unserialize(serialize($classMetadata)));
    }
}
