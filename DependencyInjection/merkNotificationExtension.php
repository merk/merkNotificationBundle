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

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Dependency injection extension
 */
class merkNotificationExtension extends Extension
{
    /**
     * Loads the extension into the DIC.
     *
     * @param array $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!in_array(strtolower($config['db_driver']), array('orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load(sprintf('%s.xml', $config['db_driver']));

        foreach (array('form', 'notifier', 'renderer', 'sender') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $container->setAlias('merk_notification.filter.manager', 'merk_notification.filter.manager.default');
        $container->setAlias('merk_notification.notification.manager', 'merk_notification.notification.manager.default');
        $container->setAlias('merk_notification.notification_event.manager', 'merk_notification.notification_event.manager.default');
        $container->setAlias('merk_notification.user_preferences.manager', 'merk_notification.user_preferences.manager.default');

        $container->setParameter('merk_notification.model_manager_name', $config['model_manager_name']);
        $container->setParameter('merk_notification.filter.class', $config['class']['filter']);
        $container->setParameter('merk_notification.notification.class', $config['class']['notification']);
        $container->setParameter('merk_notification.notification_event.class', $config['class']['notification_event']);
        $container->setParameter('merk_notification.user_preferences.class', $config['class']['user_preferences']);
    }
}
