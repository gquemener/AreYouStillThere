<?php

namespace AreYou\StillThereBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AreYou\StillThereBundle\Document\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('barret@example.com');
        $user->setUsername('barret');
        $user->setNoHeartbeatTimeLimit(86400);
        $user->addFollowers($this->getReference('unregistered-user-mario'));
        $user->addFollowers($this->getReference('unregistered-user-cratos'));
        $user->addHeartbeats($this->getReference('heartbeat-barret-1'));
        $user->addHeartbeats($this->getReference('heartbeat-barret-2'));
        $user->addHeartbeats($this->getReference('heartbeat-barret-3'));

        $manager->persist($user);

        $manager->flush();
    }

    public function getOrder()
    {
        return 30;
    }
}
