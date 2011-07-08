Provides Notification capabilities for your Symfony2 application. Notifications
can be added against a specific user who can optionally configure their own
method of notification (email, twitter, etc). Notification methods can be extended
to provide other options like SMS.

Features
========

- Notifications can be added against any User object that implements UserInterface
- User can set their own notification preferences
- Extendable notification methods with built in support for notifications
  by email.
- Twig template helpers to assist in display of notifications

Installation
============

Add NotificationBundle to your /vendor/bundles/ dir
-------------------------------------

Using the vendors script
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Add the following lines in your ``deps`` file::

    [merkNotificationBundle]
        git=git://github.com/merk/merkNotificationBundle.git
        target=bundles/merk/NotificationBundle

Run the vendors script::

    ./bin/vendors install

Using git submodules
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

::

    $ git submodule add git://github.com/merk/merkNotificationBundle.git vendor/bundles/merk/NotificationBundle

Add the merk namespace to your autoloader
----------------------------------------

::

    // app/autoload.php

    $loader->registerNamespaces(array(
        'merk' => __DIR__.'/../vendor/bundles',
        // your other namespaces
    );

Add NotificationBundle to your application kernel
-----------------------------------------

::

    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...
            new merk\NotificationBundle\merkNotificationBundle(),
            // ...
        );
    }

Configure your project
----------------------

Enable NotificationBundle in your configuration::

    # app/config/config.yml

    merk_notification: ~