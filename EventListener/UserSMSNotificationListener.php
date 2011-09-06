<?php
namespace merk\NotificationBundle\EventListener;

use merk\NotificationBundle\Model\NotificationInterface;
use merk\NotificationBundle\EventListener\NotificationListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
class UserSMSNotificationListener extends NotificationListener
{
    protected $smsService;
    protected $userPreferencesManager;
    
    public function __construct($userPreferencesManager, $smsService)
    {
        $this->userPreferencesManager = $userPreferencesManager;
        $this->smsService = $smsService;
    }

    public function onNotification(ActionInterface $action)
    {
        $user = $action->getTarget();
        if ($this->userPreferencesManager->userHasPreference($user, 'sms')) {
            $this->smsService->sendTxt($user->phoneNumber, 'Text from your favorite site', $action->getMessage());
        }
    }
}
