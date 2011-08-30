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
     * @Given /^"([^"]*)" creates a new post named "([^"]*)"$/
     */
    public function createsANewPostNamed($author, $name)
    {
        $om = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $post = new Post();
        $post->setName($name);
        $om->persist($post);
        $om->flush();

        throw new \Exception('add author support');
    }

    /**
     * @Given /^the "([^"]*)" publishes the post "([^"]*)"$/
     */
    public function thePublishesThePost($author, $postName)
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
}
