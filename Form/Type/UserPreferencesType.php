<?php

/*
 * This file is part of the merkNotificationBundle package.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace merk\NotificationBundle\Form\Type;

use merk\NotificationBundle\Notifier\UserNotifierInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserPreferencesType extends AbstractType
{
    private $class;
    private $notificationManager;

    /**
     * @param string $class The UserPreferences class name
     */
    public function __construct($class, UserNotifierInterface $notificationManager)
    {
        $this->class = $class;
        $this->notificationManager = $notificationManager;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('notificationMethods', 'choice', array(
            'choices' => $this->notificationManager->getNotifierOptions(),
            'multiple' => true,
            'expanded' => true,
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => $this->class);
    }

    public function getName()
    {
        return 'merk_notification_user_preferences';
    }
}
