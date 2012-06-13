<?php

namespace AreYou\StillThereBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AreYou\StillThereBundle\Document\Heartbeat;

class LoadHeartbeatData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $heartbeat = new Heartbeat();
        $heartbeat->setDate(new \Datetime());
        $heartbeat->setMessage('Bien arrivé en Normandie');
        $heartbeat->setLocation($this->getReference('coordinates-caen'));
        $manager->persist($heartbeat);
        $this->addReference('heartbeat-barret-1', $heartbeat);
        sleep(1);

        $heartbeat = new Heartbeat();
        $heartbeat->setDate(new \Datetime());
        $heartbeat->setMessage('Sur le départ');
        $manager->persist($heartbeat);
        $this->addReference('heartbeat-barret-2', $heartbeat);
        sleep(1);

        $heartbeat = new Heartbeat();
        $heartbeat->setDate(new \Datetime());
        $heartbeat->setMessage('Bloqué dans les bouchons');
        $manager->persist($heartbeat);
        $this->addReference('heartbeat-barret-3', $heartbeat);
        sleep(1);

        $manager->flush();
    }

    public function getOrder()
    {
        return 25;
    }
}
