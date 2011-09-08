<?php

namespace merk\NotificationBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
Behat\Behat\Context\TranslatedContextInterface,
Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
Behat\Gherkin\Node\TableNode;

use merk\NotificationBundle\Features\Document\Post;
use merk\NotificationBundle\Features\Document\User;
use merk\NotificationBundle\Features\EventListener\NotificationListener;

/**
 * Require 3rd-party libraries here:
 */
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';


/**
 * Feature context.
 */
class FeatureContext extends BehatContext //MinkContext if you want to test web
{
    protected $listener;
    protected $object = array();

    /**
     * @BeforeScenario
     */
    public function createUsers($event)
    {
        $om = $this->getObjectManager();
        $this->object['SiteOwner'] = new User();
        $this->object['SiteOwner']->setUsername('SiteOwner');
        $om->persist($this->object['SiteOwner']);
        $this->object['SiteGuest'] = new User();
        $this->object['SiteGuest']->setUsername('SiteGuest');
        $om->persist($this->object['SiteGuest']);
        $om->flush();
    }
    
    /**
     * @BeforeScenario
     */
    public function addListener()
    {
        $this->listener = new NotificationListener();
        $this->getContainer()->get('event_dispatcher')->addListener('merk_notification.notification_event', array($this->listener, 'onNotification'));
    }

    /**
     * @AfterScenario
     */
    public function emptyMongoCollections($event)
    {
        $dm = $this->getObjectManager();
        $dm->createQueryBuilder('merk\NotificationBundle\Features\Document\User')
            ->remove()
            ->getQuery()
            ->execute();
        $dm->createQueryBuilder('merk\NotificationBundle\Features\Document\Post')
            ->remove()
            ->getQuery()
            ->execute();
        $dm->createQueryBuilder('Acme\DemoBundle\Document\Notification')
            ->remove()
            ->getQuery()
            ->execute();
    }

    /**
     * @Given /^"([^"]*)" creates a new post named "([^"]*)"$/
     */
    public function createsANewPostNamed($author, $postName)
    {
        $om = $this->getObjectManager();
        $this->object[$author] = $this->getUser($author);
        $this->object[$postName] = new Post();
        $this->object[$postName]->setName($postName);
        $this->object[$postName]->setAuthor($this->object[$author]);
        $om->persist($this->object[$postName]);
        $om->flush();
        assertNotNull($this->object[$postName]->getId());
    }

    /**
     * @Given /^the "([^"]*)" publishes the post "([^"]*)"$/
     */
    public function thePublishesThePost($author, $postName)
    {
        $om = $this->getObjectManager();
        $this->post[$postName] = $om->createQueryBuilder('merk\NotificationBundle\Features\Document\Post')
            ->field('name')->equals($postName)
            ->getQuery()
            ->execute()
            ->getSingleResult();
        $this->post[$postName]->publish();
        $om->flush();
    }

    /**
     * @Then /^a notification is dispatched$/
     */
    public function aNotificationIsDispatched()
    {
        assertNotNull($this->listener->getNotification(), 'A notification event should have been dispatched');
    }

    /**
     * @Given /^a reference to "([^"]*)" is persisted as the "([^"]*)" of the notification$/
     */
    public function aReferenceToIsPersistedAsTheOfTheNotification($object, $part)
    {
        $function = 'get' . ucfirst($part);
        assertSame($this->object[$object], $this->listener->getNotification()->$function());
    }

    /**
     * @Given /^"([^"]*)" is persisted as the verb of the notification$/
     */
    public function isPersistedAsTheVerbOfTheNotification($string)
    {
        $part = 'verb';
        $function = 'get' . ucfirst($part);
        assertSame($string, $this->listener->getNotification()->$function());
    }

    /**
     * @Given /^the "([^"]*)" updates the post "([^"]*)"$/
     */
    public function theUpdatesThePost($author, $argument2)
    {
        throw new PendingException();
    }

    /**
     * @Given /^"([^"]*)" creates a comment on the post "([^"]*)"$/
     */
    public function createsACommentOnThePost($author, $postName)
    {
        throw new PendingException();
    }

    /**
     * @Given /^"([^"]*)" deletes the post "([^"]*)"$/
     */
    public function deletesThePost($author, $postName)
    {
        throw new PendingException();
    }

    protected function getUser($username)
    {
        return $this->getObjectManager()->createQueryBuilder('merk\NotificationBundle\Features\Document\User')
            ->field('username')->equals($username)
            ->getQuery()
            ->execute()
            ->getSingleResult();
    }
    
    protected function getObjectManager()
    {
        return $this->getContainer()->get('doctrine.odm.mongodb.default_document_manager');
    }
}
