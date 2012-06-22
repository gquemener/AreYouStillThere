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
        $mario = new UnregisteredUser();
        $mario->setEmail('mario@example.com');
        $manager->persist($mario);
        $this->addReference('unregistered-user-mario', $mario);

        $cratos = new UnregisteredUser();
        $cratos->setEmail('cratos@example.com');
        $manager->persist($cratos);
        $this->addReference('unregistered-user-cratos', $cratos);

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
