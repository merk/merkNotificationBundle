<?php
namespace merk\NotificationBundle\Tests\Metadata;

use merk\NotificationBundle\Model\Notification;
use merk\NotificationBundle\Metadata\ClassMetadata;
use merk\NotificationBundle\Metadata\PropertyMetadata;
use merk\NotificationBundle\Tests\Fixture\Post;
use merk\NotificationBundle\Tests\Fixture\User;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class PropertyMetadataTest extends \PHPUnit_Framework_TestCase
{
    public function testBindToNotification()
    {
        $user = new User;
        $user->setUsername('testuser');
        $post = new Post;
        $post->setName('My test post');
        $post->setAuthor($user);
        $post->publish();

        $classMetadata = new ClassMetadata($post);
        $propertyMetadata = new PropertyMetadata('merk\NotificationBundle\Tests\Fixture\Post', 'published', $classMetadata);
        $propertyMetadata->actor  = 'author';
        $propertyMetadata->object = 'this';
        $propertyMetadata->trigger = 'true';
        $propertyMetadata->verb = 'publish';
        $classMetadata->addPropertyMetadata($propertyMetadata);

        $notification = new Notification();
        $propertyMetadata->bindToNotification($notification, $post);
        $this->assertSame($post, $notification->getObject());
        $this->assertSame($user, $notification->getActor());
        $this->assertSame('publish', $notification->getVerb());
    }
}
