<?php

/**
 * This file is part of the NotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace merk\NotificationBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Notifications Controller
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class NotificationController extends ContainerAware
{
    public function listAction()
    {
        $notifications = $this->container->get('merk_notification.manager.notification')->getNotifications();

        return $this->container->get('templating')->renderResponse('merkNotificationBundle:Notification:list.html.twig', array(
            'notifications' => $notifications,
        );
    }

    public function viewAction($id)
    {
        $notification = $this->container->get('merk_notification.manager.notification')->getNotification($id);

        if (!$notification) {
            throw new NotFoundHttpException('Notification Not Found');
        }

        return $this->container->get('templating')->renderResponse('merkNotificationBundle:Notification:view.html.twig', array(
            'notification' => $notification,
        );
    }

    public function redirectAction($id)
    {
        $notification = $this->container->get('merk_notification.manager.notification')->getNotification($id);

        if (!$notification) {
            throw new NotFoundHttpException('Notification Not Found');
        }
    }
}
