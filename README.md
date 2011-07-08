Provides Notification capabilities for your Symfony2 application. Notifications
can be added against a specific user who can optionally configure their own
method of notification (email, twitter, etc). Notification methods can be extended
to provide other options like SMS.

Basic Usage

Creation of a notification

This example is adding a notification for a user in a controller.

    $user = $object->getOwner(); // $user should be populated with a UserInterface object.
    $notification = $this->container->get('merk_notification.creator.notification')->createNotification($user);

    $actor = $this->container->get('security.context')->getToken()->getUser();
    $notification->setActor($actor);
    $notification->setSubject($object);
    $notification->setMessage("%s acted on your object");

    $this->container->get('merk_notification.manager.notification')->addNotification($notification);




For documentation, see:

    Resources/doc/index.rst


License:

    Resources/meta/LICENSE