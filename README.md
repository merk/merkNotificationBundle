# Description of NotificationBundle

Provides Notification capabilities for your Symfony2 application. Notifications
can be added against a specific user who can optionally configure their own
method of notification (email, twitter, etc). Notification methods can be extended
to provide other options like SMS.

##Basic Usage
###Creation of a notification


This example is adding a notification for a user in a controller.

```php

    $user = $object->getOwner(); // $user should be populated with a UserInterface object.
    $actor = $this->container->get('security.context')->getToken()->getUser();
    $action = $this->container->get('merk_notification.action.manager')->createAction($user, $actor);

    $action->setSubject($object);
    $action->setMessage("Something was done to your object");

    $this->container->get('merk_notification.action.manager')->addAction($action);
```

This example is using annotations in the model to trigger a notification.

```php

    class Post
    {
        /**
         * @ORM\Column(type="boolean")
         * @Notify(trigger="true", object="this", verb="publish", actor="author")
         */
        protected $published = false;

        /**
         * @ORM\OneToOne(targetEntity="merk\NotificationBundle\Features\Entity\User")
         * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
         */
        protected $author;

        ... 
```

This annotation indicates that when published is set to true, a notification is created that sets the object to that
instance, the verb is publish and the author is the contents of $author.

### Display of notifications in a Twig template
```jinga

    You have {{ merk_notification.action_count }} notifications.

    <ul>
    {{ for action in merk_notification.actions }}
        <li>{{ action.message }}</li>
    {{ endfor }}
    </ul>
```


For documentation, see:

    Resources/doc/index.rst


License:

    Resources/meta/LICENSE