<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Preference Controller
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class UserPreferencesController extends ContainerAware
{
    /**
     * Returns the user preferences manager.
     *
     * @return \merk\NotificationBundle\Model\UserPreferencesManagerInterface
     */
    protected function getUserPreferencesManager()
    {
        return $this->container->get('merk_notification.user_preferences.manager');
    }

    /**
     * Returns the user preferences object for the supplied user. If no user
     * is supplied, it uses the currently logged in user.
     *
     * @param null|\Symfony\Component\Security\Core\User\UserInterface $user
     * @return \merk\NotificationBundle\Model\UserPreferencesInterface
     */
    protected function getUserPreferences(UserInterface $user = null)
    {
        if (null === $user) {
            $token = $this->container->get('security.context')->getToken();

            if (!$token->getUser() instanceof UserInterface) {
                throw new \RuntimeException('No user found in the security context');
            }

            $user = $token->getUser();
        }

        return $this->getUserPreferencesManager()->findByUser($user);
    }

    /**
     * Provides editing capability for users to edit their notification
     * preferences.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $preferences = $this->getUserPreferences();

        /** @var \Symfony\Component\Form\FormFactory $formBuilder  */
        $formBuilder = $this->container->get('form.factory');
        $form = $formBuilder->createNamed('merk_notification_user_preferences', 'merk_notification_user_preferences', $preferences);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->getUserPreferencesManager()->update($preferences);

                $this->container->get('session')->setFlash('merk_notification_success', 'user_preferences.flash.updated');
                $preferencesUrl = $this->container->get('router')->generate('merk_notification_user_preferences');

                return new RedirectResponse($preferencesUrl);
            }
        }

        return $this->container->get('templating')->renderResponse('merkNotificationBundle:UserPreferences:edit.html.twig', array(
            'form' => $form->createView(),
            'preferences' => $preferences,
        ));
    }
}