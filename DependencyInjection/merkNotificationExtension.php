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

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Configures the DI container for CommentBundle.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class merkNotificationExtension extends Extension
{
    /**
     * Loads and processes configuration to configure the Container.
     *
     * @throws InvalidArgumentException
     * @param array $configs
     * @param ContainerBuilder $container
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->process($configuration->getConfigTree(), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!in_array(strtolower($config['db_driver']), array('orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load(sprintf('%s.xml', $config['db_driver']));

        foreach (array('twig', 'user_preferences') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $container->setParameter('merk_notification.model.notification.class', $config['class']['model']['notification']);
        $container->setAlias('merk_notification.manager.notification', $config['service']['manager']['notification']);

        $container->setParameter('merk_notification.model.user_preferences.class', $config['class']['model']['user_preferences']);
        $container->setAlias('merk_notification.manager.user_preferences', $config['service']['manager']['user_preferences']);
        $container->setParameter('merk_notification.form_type.user_preferences', 'merk_notification_user_preferences');
        $container->setParameter('merk_notification.form_name.user_preferences', 'merk_notification_user_preferences');
        $container->setAlias('merk_notification.form_handler.user_preferences', 'merk_notification.form_handler.user_preferences.default');
    }
}
