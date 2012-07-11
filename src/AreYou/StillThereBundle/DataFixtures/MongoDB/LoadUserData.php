<?php

namespace AreYou\StillThereBundle\DataFixtures\MongoDB;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AreYou\StillThereBundle\Document\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    private function createUser(array $data = array())
    {
        $user = new User();

        foreach ($data as $key => $value) {
            $user->$key($value);
        }

        return $user;
    }

    public function load(ObjectManager $manager)
    {
        $barret = $this->createUser([
            'setEmail'                => 'barret@example.com',
            'setUsername'             => 'barret',
            'setNoHeartbeatTimeLimit' => 172800,
            'setPassword'             => 'barretpass',
            'setBeaconActivated'      => true,
        ]);

        $cid = $this->createUser([
            'setEmail'                => 'cid@example.com',
            'setUsername'             => 'cid',
            'setNoHeartbeatTimeLimit' => 86400,
            'setPassword'             => 'cidpass',
            'setBeaconActivated'      => true,
        ]);

        $cid->addFollower($barret);

        $barret->setPassword($this->getPassword($barret));
        $cid->setPassword($this->getPassword($cid));

        $manager->persist($barret);
        $manager->persist($cid);

        $this->addReference('barret', $barret);
        $this->addReference('cid', $cid);

        $manager->flush();
    }

    private function getPassword($user)
    {
        return $this
            ->container
            ->get('security.encoder_factory')
            ->getEncoder($user)
            ->encodePassword($user->getPassword(), $user->getSalt());
    }

    public function getOrder()
    {
        return 20;
    }
}
