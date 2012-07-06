<?php

namespace AreYou\StillThereBundle\Document;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(collection="users")
 */
class User extends UnregisteredUser implements UserInterface, \Serializable
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $email;

    /**
     * @MongoDB\String
     * @MongoDB\UniqueIndex(order="asc")
     */
    protected $username;

    /**
     * @MongoDB\ReferenceMany(
     *   discriminatorMap={
     *      "user"="User",
     *      "unregisteredUser"="UnregisteredUser"
     *   }
     * )
     */
    protected $followers;

    /**
     * @MongoDB\ReferenceMany(
     *   targetDocument="Heartbeat",
     *   mappedBy="user",
     *   sort={"date"="desc"}
     * )
     */
    protected $heartbeats;

    /**
     * @MongoDB\Int
     */
    protected $noHeartbeatTimeLimit;

    /**
     * @MongoDB\String
     */
    protected $password;

    /**
     * @MongoDB\String
     */
    protected $salt;

    public function __construct()
    {
        $this->followers  = new ArrayCollection();
        $this->heartbeats = new ArrayCollection();
        $this->salt       = md5(uniqid(null, true));
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function addFollowers($followers)
    {
        $this->followers[] = $followers;
    }

    public function getFollowers()
    {
        return $this->followers;
    }

    public function setNoHeartbeatTimeLimit($noHeartbeatTimeLimit)
    {
        $this->noHeartbeatTimeLimit = $noHeartbeatTimeLimit;
    }

    public function getNoHeartbeatTimeLimit()
    {
        return $this->noHeartbeatTimeLimit;
    }

    public function addHeartbeats(Heartbeat $heartbeat)
    {
        $this->heartbeats[] = $heartbeat;
    }

    public function getHeartbeats()
    {
        return $this->heartbeats;
    }

    public function getLastHeartbeat()
    {
        return $this->heartbeats->first();
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function eraseCredentials()
    {
    }

    public function equals(UserInterface $user)
    {
        return $this->id === $user->getId();
    }

    public function serialize()
    {
        return serialize(array($this->id, $this->username));
    }

    public function unserialize($serialized)
    {
        list($this->id, $this->username) = unserialize($serialized);
    }
}
