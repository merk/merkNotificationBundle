<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('merk_notification');

        $rootNode
            ->children()
                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('model_manager_name')->defaultValue('default')->end()
                ->arrayNode('class')->children()
                    ->scalarNode('filter')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('notification')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('notification_event')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('user_preferences')->isRequired()->cannotBeEmpty()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
