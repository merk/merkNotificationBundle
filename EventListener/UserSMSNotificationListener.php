<?php
namespace merk\NotificationBundle\EventListener;

use merk\NotificationBundle\Model\NotificationInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class UserSMSNotificationListener
{
    protected $smsService;
    protected $userPreferencesManager;
    
    public function __construct($userPreferencesManager, $smsService)
    {
        $this->userPreferencesManager = $userPreferencesManager;
        $this->smsService = $smsService;
    }

    public function onNotification(NotificationInterface $notification)
    {
        $user = $notification->getTarget();
        if ($this->userPreferencesManager->userHasPreference($user, 'sms')) {
            $this->smsService->sendTxt($user->phoneNumber, 'Text from your favorite site', $notification->getMessage());
        }
    }
}
