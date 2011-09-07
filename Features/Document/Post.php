<?php

namespace merk\NotificationBundle\Features\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use merk\NotificationBundle\Annotation\Notify;

/**
 * @MongoDB\Document(collection="post")
 */
class Post
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="merk\NotificationBundle\Features\Document\User")
     */
    protected $author;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\Boolean
     * @Notify(trigger="true", object="this", verb="publish", author="author")
     */
    protected $published = false;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function publish()
    {
        $this->published = true;
    }

    public function isPublished()
    {
        return $this->published;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }
}
