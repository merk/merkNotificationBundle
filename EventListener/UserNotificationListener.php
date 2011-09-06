<?php
namespace merk\NotificationBundle\EventListener;

use merk\NotificationBundle\Model\NotificationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
 * @author Richard D Shank <develop@zestic.com>
 */
class UserNotificationListener implements EventSubscriberInterface
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

    static public function getSubscribedEvents()
    {
        return array(
            'user.notification' => 'onUserNotification',
        );
    }

    public function onUserNotification(ActionInterface $action)
    {
        $prefs = $this->userPreferencesManager->findByUser($action->getTarget());

        foreach ($prefs->getNotificationMethods() AS $pref) {
            $notifyMethod = 'notifyBy' . ucfirst(strtolower($pref));
            $this->$notifyMethod($action);
        }
    }

    protected function notifyByEmail(ActionInterface $action)
    {
        $email = $this->emailService->createMessage()
            ->setSubject('Notification from your favorite site')
            ->setFrom('send@example.com')
            ->setTo($action->getTarget()->getEmail())
            ->setBody($this->templating->renderView('NotificationBundle:Notify.txt.twig', array('message' => $action->getMessage())))
        ;
        $this->emailService->send($email);
    }
}
