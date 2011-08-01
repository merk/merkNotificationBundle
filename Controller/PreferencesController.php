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
 * Preference Controller
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class PreferencesController extends ContainerAware
{
    public function editAction()
    {
        $preferences = $this->container->get('merk_notification.user_preferences.manager')->getPreferences();
        $form = $this->container->get('merk_notification.user_preferences.form');
        $formHandler = $this->container->get('merk_notification.user_preferences.form.handler');

        $process = $formHandler->process($preferences);
        if ($process) {
            $this->container->get('session')->setFlash('merk_notification_success', 'user_preferences.flash.updated');
            $preferencesUrl = $this->container->get('router')->generate('merk_notification_user_preferences');

            return new RedirectResponse($preferencesUrl);
        }

        return $this->container->get('templating')->renderResponse('merkNotificationBundle:Preferences:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
