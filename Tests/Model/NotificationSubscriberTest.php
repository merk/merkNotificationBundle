<?php
namespace merk\NotificationBundle\Tests\Model;

use merk\NotificationBundle\Model\NotificationSubscriber;
use merk\NotificationBundle\Features\Entity\Nothing;
use merk\NotificationBundle\Features\Entity\Post;
use merk\NotificationBundle\Features\Entity\User;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class NotificationSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function testTriggerNotification()
    {
        $ns = $this->getMockForAbstractClass('merk\NotificationBundle\Model\NotificationSubscriber', array($this->getKernel()->getContainer()));
        $triggerNotification = new \ReflectionMethod($ns,'triggerNotification');
        $triggerNotification->setAccessible(true);
        // boolean
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('true', true)), 'true trigger should fire when true');
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('true', false)), 'true trigger should not fire when false');
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('false', false)), 'false trigger should fire when false');
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('false', true)), 'false trigger should not fire when true');
        // null
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('null', null)), 'null trigger should fire when null');
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('null', true)), 'null trigger should not fire when not null');
        // number
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('3', 3)), 'numeric trigger should fire when numbers match');
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('3', 4)), 'numeric trigger should not fire when numbers don\'t match');
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('3', '3')), 'numeric trigger should work with numeric strings that match');
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('3', '30')), 'numeric trigger should not work with numeric strings that don\'t match');
        // array
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('[a, b, c]', 'b')), 'match in array trigger should fire');
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('[a, b, c]', 'd')), 'no match in array trigger should not fire');
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('[3, 5, 7]', 3)), 'numeric trigger should fire when numbers match');
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('[3, 5, 7]', 4)), 'numeric trigger should not fire when numbers don\'t match');
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('[3, 5, 7]', '3')), 'numeric trigger should work with numeric strings that match');
        // comparison operators
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('=== 3', '3')), 'comparison operators rule!');
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('=== 3', 3)), 'comparison operators rule!');

        // not
        $this->assertFalse($triggerNotification->invokeArgs($ns, array('not null', null)), 'null added to the trigger should have the opposite effect');
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('not 3', 4)), 'null added to the trigger should have the opposite effect');
        $this->assertTrue($triggerNotification->invokeArgs($ns, array('not [a, b, c]', 'd')), 'null added to the trigger should have the opposite effect');
    }
}
