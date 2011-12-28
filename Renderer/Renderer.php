<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Renderer;

use merk\NotificationBundle\Model\NotificationInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Renders the template for a notification.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class Renderer implements RendererInterface
{
    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $engine;

    /**
     * @var string
     */
    protected $nameTemplate;

    /**
     * @param \Symfony\Component\Templating\EngineInterface $engine
     * @param string $nameTemplate
     */
    public function __construct(EngineInterface $engine, $nameTemplate)
    {
        $this->engine = $engine;
        $this->nameTemplate = $nameTemplate;
    }

    /**
     * Renders the template required for the notification
     * TODO: consider caching the result of a render
     *
     * @param \merk\NotificationBundle\Model\NotificationInterface $notification
     *
     * @return array(
     *             'subject' => // Subject to be used for the notification,
     *             'body' => // Body of the notification
     *         )
     */
    public function render(NotificationInterface $notification)
    {
        $templateName = $this->resolveTemplateName($notification);

        $rendered = $this->engine->render($templateName, array(
            'notification' => $notification
        ));

        $firstNewline = strpos($rendered, "\n");
        $subject = substr($rendered, 0, $firstNewline);
        $body = substr($rendered, $firstNewline + 1);

        return compact('subject', 'body');
    }

    /**
     * Resolves the template name to be used for the supplied notification.
     *
     * Starts by using the entire notification event key, while reducing it
     * to be less specific if the template is not found. If there is no
     * template found the base template for the sending method will be used.
     *
     *     some.event.key => some.event.key.email.txt.twig
     *                    => some.event.email.txt.twig
     *                    => some.email.txt.twig
     *                    => base.email.txt.twig
     *
     * @param \merk\NotificationBundle\Model\NotificationInterface $notification
     * @return string
     */
    protected function resolveTemplateName(NotificationInterface $notification)
    {
        $key = explode('.', $notification->getEvent()->getNotificationKey());

        while (count($key)) {
            $templateName = $this->buildTemplateName(
                implode('.', $key),
                $notification->getMethod(),
                'txt'
            );

            if ($this->engine->exists($templateName)) {
                return $templateName;
            }

            array_pop($key);
        }

        return $this->buildTemplateName('base', $notification->getMethod(), 'txt');
    }

    /**
     * Combines given parameters into the template name template.
     *
     * @param string $notificationKey
     * @param string $method
     * @param string $format
     * @return string
     */
    protected function buildTemplateName($notificationKey, $method, $format = 'txt')
    {
        return sprintf($this->nameTemplate,
            $notificationKey,
            $method,
            $format
        );
    }
}