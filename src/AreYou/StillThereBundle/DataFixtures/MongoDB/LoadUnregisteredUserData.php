<?php

namespace AreYou\StillThereBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AreYou\StillThereBundle\Document\UnregisteredUser;

class LoadUnregisteredUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $unregUser = new UnregisteredUser();
        $unregUser->setEmail('mario@example.com');
        $manager->persist($unregUser);
        $this->addReference('unregistered-user-mario', $unregUser);

        $unregUser = new UnregisteredUser();
        $unregUser->setEmail('cratos@example.com');
        $manager->persist($unregUser);
        $this->addReference('unregistered-user-cratos', $unregUser);

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
