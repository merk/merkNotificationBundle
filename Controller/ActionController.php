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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Notifications Controller
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class ActionController extends ContainerAware
{

    public function listAction()
    {
        $actions = $this->container->get('merk_notification.manager.action')->getAction();

        return $this->container->get('templating')->renderResponse('merkNotificationBundle:Action:list.html.twig', array(
            'actions' => $actions,
        ));
    }

    public function viewAction($id)
    {
        $action = $this->container->get('merk_notification.manager.action')->getAction($id);

        if (!$action) {
            throw new NotFoundHttpException('Action Not Found');
        }

        return $this->container->get('templating')->renderResponse('merkNotificationBundle:Action:view.html.twig', array(
            'action' => $action,
        ));
    }

    public function redirectAction($id)
    {
        $action = $this->container->get('merk_notification.manager.action')->getAction($id);

        if (!$action) {
            throw new NotFoundHttpException('Action Not Found');
        }

        $uri = $this->container->get('router')->generate($action->getRouteName(), $action->getRouteParameters());
        return new RedirectResponse($uri);
    }
}
