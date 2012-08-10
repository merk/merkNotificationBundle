Getting Started With merkNotificationBundle
===========================================

This bundle provides notification services for your application. You
are able to define specific events that will occur in your programs
lifecycle that users will be able to subscribe to, and be notified
when they occur.

Features yet to be added include:
 * Setting NotificationBundle to listen for events sent with Symfony2's Event Dispatcher
 * Metadata (annotations, yml, xml) definitions on objects that will automatically trigger notification events
 * Additional sending methods, besides email (twitter, sms, etc)
 * A method of defining notification events that will occur in runtime (so that users can preselect event keys)

## Basic Usage

Once users have set up their notification preferences and filters,
NotificationBundle will send notifications when they are fired by your code.

To fire an event:

``` php
<?php

    // $actor -- UserInterface object
    // $subject -- An object managed by the Doctrine ORM

    $this->container->get('merk_notification.notifier')->trigger('event.key', $subject, 'viewed', $actor);
```

## Prerequisites

### Swift Mailer

At this point, Notification bundle is only capable of sending email
notifications and requires Swift Mailer to be set up appropriately.

## Installation

1. Download merkNotificationBundle
2. Configure the Autoloader
3. Enable the Bundle
4. Create the needed classes in your Application
5. Configure the merkNotificationBundle
6. Import merkNotificationBundle routing
7. Update your database schema

### Step 1: Download merkNotificationBundle

Ultimately, the merkNotificationBundle files should be downloaded to the
`vendor/bundles/merk/NotificationBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script**

Add the following lines in your `deps` file:

```
[merkNotificationBundle]
    git=git://github.com/merk/merkNotificationBundle.git
    target=bundles/merk/NotificationBundle
```

Now, run the vendors script to download the bundle:

``` bash
$ php bin/vendors install
```

**Using submodules**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/merk/merkNotificationBundle.git vendor/bundles/merk/NotificationBundle
$ git submodule update --init
```

### Step 2: Configure the Autoloader

Add the `merk` namespace to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'merk' => __DIR__.'/../vendor/bundles',
));
```

### Step 3: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new merk\NotificationBundle\merkNotificationBundle(),
    );
}
```

### Step 4: Create the needed classes in your Application

NotificationBundle provides multiple abstract classes that need to be
implemented. At this time, only a Doctrine ORM implementation is
provided.

- Notification; Represents a notification that is sent to a user
- NotificationEvent; Represents an event that occurs that will trigger notifications
- UserPreferences; an object to hold default preferences for each user
- Filter; an object that is used to store user defined filters for notifications

**Warning:**

> When you extend from the mapped superclass provided by the bundle, don't
> redefine the mapping for the other fields as it is provided by the bundle.

**Warning:**

> If you override the __construct() method in any of these classes, be sure
> to call parent::__construct() if the parent has a constructor.

``` php
<?php

// src/Company/AppBundle/Entity/Filter.php

namespace Company\AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Company\UserBundle\Entity\User;
use merk\NotificationBundle\Entity\Filter as BaseFilter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="notification_userfilter")
 */
class Filter extends BaseFilter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Company\AppBundle\Entity\UserPreferences", inversedBy="filters")
     * @var UserPreferences
     */
    protected $userPreferences;
}
```

``` php
<?php

// src/Company/AppBundle/Entity/Notification.php

namespace Company\AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Company\UserBundle\Entity\User;
use merk\NotificationBundle\Entity\Notification as BaseNotification;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="notification")
 */
class Notification extends BaseNotification
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Company\UserBundle\Entity\User")
     * @var \Company\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Company\AppBundle\Entity\NotificationEvent", inversedBy="notifications")
     * @var NotificationEvent
     */
    protected $event;
}
```

``` php
<?php

namespace Company\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping AS ORM;
use Company\UserBundle\Entity\User;
use merk\NotificationBundle\Entity\NotificationEvent as BaseNotificationEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="Company_notificationevent")
 * @ORM\HasLifecycleCallbacks
 */
class NotificationEvent extends BaseNotificationEvent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Company\UserBundle\Entity\User")
     * @var \Company\UserBundle\Entity\User
     */
    protected $actor;

    /**
     * @ORM\OneToMany(targetEntity="Company\AppBundle\Entity\Notification", mappedBy="event")
     * @var \Doctrine\Common\Collection\Collection
     */
    protected $notifications;

    public function __construct($key, $subject, $verb, UserInterface $actor = null, DateTime $createdAt = null)
    {
        parent::__construct($key, $subject, $verb, $actor, $createdAt);

        $this->notifications = new ArrayCollection;
    }

    /**
     * Sets the actor for the event.
     *
     * @param null|\Symfony\Component\Security\Core\User\UserInterface $actor
     * @throws \InvalidArgumentException when the $actor is not a User object
     */
    protected function setActor(UserInterface $actor = null)
    {
        if (null !== $actor and !$actor instanceof User) {
            throw new \InvalidArgumentException('Actor must be a User');
        }

        $this->actor = $actor;
    }

    public function getNotifications()
    {
        return $this->notifications;
    }
}
```

``` php
<?php

namespace Company\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Company\UserBundle\Entity\User;
use merk\NotificationBundle\Entity\UserPreferences as BaseUserPreferences;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="notification_userprefs")
 */
class UserPreferences extends BaseUserPreferences
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Company\UserBundle\Entity\User")
     * @var \Company\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Company\AppBundle\Entity\Filter", mappedBy="userPreferences")
     * @var \Doctrine\Common\Collection\Collection
     */
    protected $filters;

    public function __construct()
    {
        $this->filters = new ArrayCollection;
    }

    /**
     * @return \Doctrine\Common\Collection\Collection
     */
    public function getFilters()
    {
        return $this->filters;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
```

### Step 5: Configure the merkNotificationBundle

Notification bundle does not contain much configuration, at the current time
the only configuration is database driver and FQCN of the classes you defined
above.

``` yaml
merk_notification:
    db_driver: orm
    class:
        filter: Company\AppBundle\Entity\Filter
        notification: Company\AppBundle\Entity\Notification
        notification_event: Company\AppBundle\Entity\NotificationEvent
        user_preferences: Company\AppBundle\Entity\UserPreferences
```

### Step 6: Import merkNotificationBundle routing files

NotificationBundle provides routing for a default UserPreferences controller.

In YAML:

``` yaml
# app/config/routing.yml
merk_notification:
    resource: "@merkNotificationBundle/Resources/config/routing/user_preferences.yml"
```

### Step 7: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a new entity, the `User` class which you
created in Step 2.

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 8: Overwrite templates for specific events

The first line of the rendered output is used as the subject (when used by the
sending agent), with the rest of the output being used in the notification body.

The rendering of each notification follows a specific path while trying to find
which template to use.

The logic used to find the template follows the path outlined below:

```
    some.event.key => some.event.key.email.txt.twig
                   => some.event.email.txt.twig
                   => some.email.txt.twig
                   => base.email.txt.twig
```

The templates should be placed in `app/Resources/merkNotificationBundle/views/Notifications`
and should extend the base template, though they dont have to. There is one variable passed
into the template, `notification` which contains the individual notification sent for a
single user.

The template is rendered separately for each user to be notified for each notification type.
