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
        $heartbeat->setUser($this->getReference('barret'));
        $manager->persist($heartbeat);
        sleep(1);

        $heartbeat = new Heartbeat();
        $heartbeat->setDate(new \Datetime());
        $heartbeat->setMessage('Sur le départ');
        $heartbeat->setUser($this->getReference('barret'));
        $manager->persist($heartbeat);
        sleep(1);

        $heartbeat = new Heartbeat();
        $heartbeat->setDate(new \Datetime());
        $heartbeat->setMessage('Bloqué dans les bouchons');
        $heartbeat->setUser($this->getReference('barret'));
        $manager->persist($heartbeat);
        sleep(1);

        $manager->flush();
    }

    public function getOrder()
    {
        return 30;
    }
}
