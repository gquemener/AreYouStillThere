<?php

namespace AreYou\StillThereBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ODM\MongoDB\Events;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

use AreYou\StillThereBundle\Document\Heartbeat;

class HeartbeatListener implements EventSubscriber
{
    // Mail notification service
    private $heartbeatSender;

    // ZeroMQ pipe to communicate with node server
    private $zmq;

    public function __construct($heartbeatSender, $zmq)
    {
        $this->heartbeatSender = $heartbeatSender;
        $this->zmq             = $zmq;
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
        $this->zmq->send($heartbeat);
    }
}
