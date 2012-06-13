<?php

namespace AreYou\StillThereBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AreYou\StillThereBundle\Document\Coordinates;

class LoadCoordinatesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $coordinates = new Coordinates();
        $coordinates->setLatitude(49.18218);
        $coordinates->setLongitude(-0.370831);
        $manager->persist($coordinates);
        $this->addReference('coordinates-caen', $coordinates);

        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }
}
