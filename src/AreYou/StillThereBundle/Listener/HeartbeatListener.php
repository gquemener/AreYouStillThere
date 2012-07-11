<?php

namespace AreYou\StillThereBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ODM\MongoDB\Events;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

use AreYou\StillThereBundle\Document\Heartbeat;

class HeartbeatListener implements EventSubscriber
{
    private $heartbeatSender;

    public function __construct($heartbeatSender)
    {
        $this->heartbeatSender = $heartbeatSender;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
        );
    }

    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $heartbeat = $eventArgs->getDocument();

        if (!$heartbeat instanceof Heartbeat) {
            return;
        }

        $user = $heartbeat->getUser();

        $this->heartbeatSender->notify($user);
    }
}
