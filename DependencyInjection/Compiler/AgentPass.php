<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use InvalidArgumentException;

/**
 * Registers Sorting implementations.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class AgentPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('merk_notification.sender')) {
            return;
        }

        $senders = array();
        foreach ($container->findTaggedServiceIds('merk_notification.sender.agent') as $id => $tags) {
            foreach ($tags as $tag) {
                if (empty($tag['alias'])) {
                    throw new InvalidArgumentException(sprintf('The Sending Agent "%s" must have an alias', $id));
                }

                $senders[$tag['alias']] = new Reference($id);
            }
        }

        $container->getDefinition('merk_notification.sender')->replaceArgument(0, $senders);
    }
}