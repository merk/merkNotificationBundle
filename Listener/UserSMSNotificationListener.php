<?php
namespace merk\NotificationBundle\Listener;

use merk\NotificationBundle\Model\ActionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
class UserSMSNotificationListener implements EventSubscriberInterface
{
    protected $smsService;
    protected $userPreferencesManager;
    
    public function __construct($userPreferencesManager, $smsService)
    {
        $this->userPreferencesManager = $userPreferencesManager;
        $this->smsService = $smsService;
    }

    static public function getSubscribedEvents()
    {
        return array(
            'user.notification' => 'onUserNotification',
        );
    }

    public function onUserNotification(ActionInterface $action)
    {
        $user = $action->getTarget();
        if ($this->userPreferencesManager->userHasPreference($user, 'sms')) {
            $this->smsService->sendTxt($user->phoneNumber, 'Text from your favorite site', $action->getMessage());
        }
    }
}
