<?php
namespace merk\NotificationBundle\EventListener;

use Doctrine\ODM\MongoDB\DocumentManager;
use merk\NotificationBundle\Model\NotificationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class MongoDBListener
{
    protected $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function onNotification(NotificationInterface $notification)
    {
        $this->dm->persist($notification);
        $this->dm->flush();
    }
}
