<?php

namespace AreYou\StillThereBundle\Document;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

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
     * @MongoDB\ReferenceMany(targetDocument="Heartbeat", sort={"date"="-1"})
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
        $this->followers  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->heartbeats = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salt       = md5(uniqid(null, true));
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Add followers
     *
     * @param $followers
     */
    public function addFollowers($followers)
    {
        $this->followers[] = $followers;
    }

    /**
     * Get followers
     *
     * @return Doctrine\Common\Collections\Collection $followers
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * Set noHeartbeatTimeLimit
     *
     * @param int $noHeartbeatTimeLimit
     */
    public function setNoHeartbeatTimeLimit($noHeartbeatTimeLimit)
    {
        $this->noHeartbeatTimeLimit = $noHeartbeatTimeLimit;
    }

    /**
     * Get noHeartbeatTimeLimit
     *
     * @return int $noHeartbeatTimeLimit
     */
    public function getNoHeartbeatTimeLimit()
    {
        return $this->noHeartbeatTimeLimit;
    }

    /**
     * Add heartbeats
     *
     * @param Heartbeat $heartbeats
     */
    public function addHeartbeats(Heartbeat $heartbeat)
    {
        $this->heartbeats[] = $heartbeat;
    }

    /**
     * Get heartbeats
     *
     * @return Doctrine\Common\Collections\Collection $heartbeats
     */
    public function getHeartbeats()
    {
        return $this->heartbeats;
    }

    public function getLastHeartbeat()
    {
        return $this->heartbeats->last();
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
