<?php

namespace merk\NotificationBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
Behat\Behat\Context\TranslatedContextInterface,
Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
Behat\Gherkin\Node\TableNode;

use merk\NotificationBundle\Features\Entity\Post;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends BehatContext //MinkContext if you want to test web
{
    /**
     * @Given /^SiteOwner creates a new post named "([^"]*)"$/
     */
    public function siteOwnerCreatesANewPostNamed($name)
    {
        $om = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $post = new Post();
        $post->setName($name);
        $om->persist($post);
        $om->flush();
    }

    /**
     * @Given /^the SiteOwner publishes "([^"]*)"$/
     */
    public function theSiteOwnerPublishes($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^a notification is created$/
     */
    public function aNotificationIsCreated()
    {
        throw new PendingException();
    }

    /**
     * @Given /^a reference to the new post is persisted as the object of the notification$/
     */
    public function aReferenceToTheNewPostIsPersistedAsTheObjectOfTheNotification()
    {
        throw new PendingException();
    }

    /**
     * @Given /^publish is persisted as the verb of the notification$/
     */
    public function publishIsPersistedAsTheVerbOfTheNotification()
    {
        throw new PendingException();
    }

    /**
     * @Given /^a reference to SiteOwner is persisted as the actor of the notification$/
     */
    public function aReferenceToSiteOwnerIsPersistedAsTheActorOfTheNotification()
    {
        throw new PendingException();
    }

    /**
     * @Given /^the SiteOwner updates "([^"]*)"$/
     */
    public function theSiteOwnerUpdates($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^update is persisted as the verb of the notification$/
     */
    public function updateIsPersistedAsTheVerbOfTheNotification()
    {
        throw new PendingException();
    }

    /**
     * @Given /^SiteGuest creates a comment on "([^"]*)"$/
     */
    public function siteGuestCreatesACommentOn($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^a reference to the new comment is persisted as the object of the notification$/
     */
    public function aReferenceToTheNewCommentIsPersistedAsTheObjectOfTheNotification()
    {
        throw new PendingException();
    }

    /**
     * @Given /^add is persisted as the verb of the notification$/
     */
    public function addIsPersistedAsTheVerbOfTheNotification()
    {
        throw new PendingException();
    }

    /**
     * @Given /^a reference to SiteGuest is persisted as the actor of the notification$/
     */
    public function aReferenceToSiteGuestIsPersistedAsTheActorOfTheNotification()
    {
        throw new PendingException();
    }

    /**
     * @Given /^SiteOwner deletes "([^"]*)"$/
     */
    public function siteOwnerDeletes($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^delete is persisted as the verb of the notification$/
     */
    public function deleteIsPersistedAsTheVerbOfTheNotification()
    {
        throw new PendingException();
    }
}
