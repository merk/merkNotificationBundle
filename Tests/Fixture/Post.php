<?php

namespace merk\NotificationBundle\Tests\Fixture;

use merk\NotificationBundle\Annotation\Notify;

class Post
{
    protected $author;

    protected $name;

    /**
     * @Notify(trigger="true", object="Post", verb="publish", actor="author")
     */
    protected $published = false;

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
