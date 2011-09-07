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
    
    /**
     * @BeforeScenario
     */
    public function createUsers($event)
    {
        $om = $this->getObjectManager();
        $user = new User();
        $user->setUsername('SiteOwner');
        $om->persist($user);
        $user = new User();
        $user->setUsername('SiteGuest');
        $om->persist($user);
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
    public function createsANewPostNamed($author, $name)
    {
        $om = $this->getObjectManager();
        $author = $this->getUser($author);
        $post = new Post();
        $post->setName($name);
        $post->setAuthor($author);
        $om->persist($post);
        $om->flush();
        assertNotNull($post->getId());
    }

    /**
     * @Given /^the "([^"]*)" publishes the post "([^"]*)"$/
     */
    public function thePublishesThePost($author, $postName)
    {
        $om = $this->getObjectManager();
        $post = $om->createQueryBuilder('merk\NotificationBundle\Features\Document\Post')
            ->field('name')->equals($postName)
            ->getQuery()
            ->execute()
            ->getSingleResult();
        $post->publish();
        $om->flush();
    }

    /**
     * @Then /^a notification is created$/
     */
    public function aNotificationIsCreated()
    {
        // TODO: move db into another step
        $om = $this->getObjectManager();
        $notification = $om->createQueryBuilder('Acme\DemoBundle\Document\Notification')
            ->getQuery()
            ->execute()
            ->getSingleResult();
//        assertSame($this->getUser(''), $notification->getAuthor());
        assertNotEmpty($this->listener->getNotifications());
    }

    /**
     * @Given /^a reference to "([^"]*)" is persisted as the "([^"]*)" of the notification$/
     */
    public function aReferenceToIsPersistedAsTheOfTheNotification($object, $part)
    {
        throw new PendingException();
    }

    /**
     * @Given /^"([^"]*)" is persisted as the verb of the notification$/
     */
    public function isPersistedAsTheVerbOfTheNotification($argument1)
    {
        throw new PendingException();
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
