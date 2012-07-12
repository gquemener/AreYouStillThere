<?php

namespace AreYou\StillThereBundle\ZMQ;

use AreYou\StillThereBundle\Document\Heartbeat;

class HeartbeatZmq
{
    private $socket;

    public function __construct($zmqUrl)
    {
        $context      = new \ZMQContext();
        $this->socket = $context->getSocket(\ZMQ::SOCKET_PUB);

        $this->socket->connect($zmqUrl);
    }

    public function send(Heartbeat $heartbeat)
    {
        $msg = $this->createMessage($heartbeat);

        $this->socket->send($msg);
    }

    private function createMessage(Heartbeat $heartbeat)
    {
        return json_encode([
            'type' => 'heartbeat:new',
            'data' => $heartbeat,
        ]);
    }
}
