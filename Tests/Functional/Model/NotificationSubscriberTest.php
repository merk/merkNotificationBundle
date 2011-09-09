<?php
namespace merk\NotificationBundle\Tests\Functional\Model;

use merk\NotificationBundle\Model\NotificationSubscriber;
use merk\NotificationBundle\Features\Entity\Nothing;
use merk\NotificationBundle\Features\Entity\Post;
use merk\NotificationBundle\Features\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationSubscriberTest extends WebTestCase
{
    public function testNonNotificationClasses()
    {

    }
    
    public function testNotificationClasses()
    {
        $user = new User();
        $user->setUsername('user');
        $post = new Post();
        $post->setName('my post');
        $post->publish();
        $post->setAuthor($user);

        // add listener to EventDispatch
        $eventDispatcher = $this->getKernel()->getContainer()->get('event_dispatcher');

        $ns = $this->getMockForAbstractClass('merk\NotificationBundle\Model\NotificationSubscriber', array($this->getKernel()->getContainer()));
        $process = new \ReflectionMethod($ns,'process');
        $process->setAccessible(true);
        $process->invokeArgs($ns, array($post));

        // use listener to test
    }

    public function getKernel(array $options = array())
    {
        self::$kernel = $this->createKernel($options);
        self::$kernel->boot();

        return self::$kernel;
    }
}
