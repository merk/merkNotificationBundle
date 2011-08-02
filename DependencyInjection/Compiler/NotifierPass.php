<?php

/**
 * This file is part of the NotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace merk\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use InvalidArgumentException;

/**
 * Registers Notifier implementations.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class NotifierPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasAlias('merk_notification.user_notifier')) {
            return;
        }

        $notifiers = array();
        foreach ($container->findTaggedServiceIds('merk_notification.notifier') as $id => $tags) {
            foreach ($tags as $tag) {
                if (empty($tag['alias'])) {
                    throw new InvalidArgumentException('The Notifier must have an alias');
                }

                $notifiers[$tag['alias']] = new Reference($id);
            }
        }

        $container->findDefinition('merk_notification.user_notifier')->replaceArgument(0, $notifiers);
    }
}
