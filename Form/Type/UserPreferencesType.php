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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserPreferencesType extends AbstractType
{
    private $class;

    /**
     * @param string $class The UserPreferences class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('notificationMethods', 'choice', array(
            'choices' => $this->getNotificationOptions(),
            'multiple' => true,
            'expanded' => true,
        ));
    }

    protected function getNotificationOptions()
    {
        return array('test' => 'hallo');
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
