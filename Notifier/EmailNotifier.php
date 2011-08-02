<?php

/**
 * This file is part of the NotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace merk\NotificationBundle\Notifier;

use merk\NotificationBundle\Model\ActionInterface;
use Symfony\Component\Templating\EngineInterface;

class EmailNotifier implements NotifierInterface
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating = null)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function notify(ActionInterface $action)
    {
        die('Send an email');
    }
}