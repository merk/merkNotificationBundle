<?php
namespace merk\NotificationBundle\EventListener;

use merk\NotificationBundle\Model\NotificationInterface;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
class UserNotificationListener
{
    protected $emailService;
    protected $templating;
    protected $userPreferencesManager;

    public function __construct($userPreferencesManager, $emailService, $templating)
    {
        $this->userPreferencesManager = $userPreferencesManager;
        $this->emailService = $emailService;
        $this->templating = $templating;
    }

    public function onNotification(NotificationInterface $notification)
    {
        $prefs = $this->userPreferencesManager->findByUser($notification->getTarget());

        foreach ($prefs->getNotificationMethods() AS $pref) {
            $notifyMethod = 'notifyBy' . ucfirst(strtolower($pref));
            $this->$notifyMethod($notification);
        }
    }

    protected function notifyByEmail(NotificationInterface $notification)
    {
        $email = $this->emailService->createMessage()
            ->setSubject('Notification from your favorite site')
            ->setFrom('send@example.com')
            ->setTo($notification->getTarget()->getEmail())
            ->setBody($this->templating->renderView('NotificationBundle:Notify.txt.twig', array('message' => $notification->getMessage())))
        ;
        $this->emailService->send($email);
    }
}
