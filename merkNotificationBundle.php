<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle;

use merk\NotificationBundle\DependencyInjection\Compiler\AgentPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * merkNotificationBundle
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class merkNotificationBundle extends Bundle
{
    /**
     * Adds a compiler pass to the container builder.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AgentPass());
    }
}
