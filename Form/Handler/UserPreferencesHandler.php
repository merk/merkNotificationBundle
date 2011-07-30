<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Form\Handler;

use merk\NotificationBundle\Model\UserPreferencesInterface;
use merk\NotificationBundle\Model\UserPreferencesManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class UserPreferencesHandler
{
    protected $request;
    protected $userPreferencesManager;
    protected $form;
    protected $securityContext;

    public function __construct(Form $form, Request $request, UserPreferencesManagerInterface $userPreferencesManager, SecurityContextInterface $securityContext)
    {
        $this->form = $form;
        $this->request = $request;
        $this->userPreferencesManager = $userPreferencesManager;
        $this->securityContext = $securityContext;
    }

    public function process(UserPreferencesInterface $preferences = null)
    {
        if (null === $preferences) {
            $user = $this->securityContext->getToken()->getUser();
            $preferences = $this->userPreferencesManager->getPreferences($user);
        }

        $this->form->setData($preferences);

        if ('POST' == $this->request->getMethod()) {
            $this->form->bindRequest($this->request);

            if ($this->form->isValid()) {
                $this->userPreferencesManager->update($preferences);
                return true;
            }
        }

        return false;
    }
}
