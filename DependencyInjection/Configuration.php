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
                ->scalarNode('model_manager_name')->defaultNull()->end()

                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('action')->isRequired()->end()
                                ->scalarNode('notification')->isRequired()->end()
                                ->scalarNode('user_preferences')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('user_preferences')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('manager')->cannotBeEmpty()->defaultValue('merk_notification.manager.user_preferences.default')->end()
                        ->scalarNode('form_type')->cannotBeEmpty()->defaultValue('merk_notification_user_preferences')->end()
                        ->scalarNode('form_name')->cannotBeEmpty()->defaultValue('merk_notification_user_preferences_form')->end()
                        ->scalarNode('form_handler')->cannotBeEmpty()->defaultValue('merk_notification.user_preferences.form.handler.default')->end()
                    ->end()
                ->end()

                ->arrayNode('action')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('manager')->cannotBeEmpty()->defaultValue('merk_notification.action.manager.default')->end()
                    ->end()
                ->end()

                ->scalarNode('user_notifier')->cannotBeEmpty()->defaultValue('merk_notification.user_notifier.default')->end()
            ->end()
        ->end();

        return $treeBuilder->buildTree();
    }
}
