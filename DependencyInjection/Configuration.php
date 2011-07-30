<?php

/**
 * This file is part of the NotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace merk\NotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 */
class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('merk_notification', 'array')
            ->children()

                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->end()

                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('notification')->isRequired()->end()
                                ->scalarNode('user_preferences')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('service')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('manager')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('notification')->cannotBeEmpty()->defaultValue('merk_notification.manager.notification.default')->end()
                                ->scalarNode('user_preferences')->cannotBeEmpty()->defaultValue('merk_notification.manager.user_preferences.default')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()


            ->end()
        ->end();

        return $treeBuilder->buildTree();
    }
}
