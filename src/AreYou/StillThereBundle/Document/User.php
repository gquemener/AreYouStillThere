<?php

namespace AreYou\StillThereBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="users")
 */
class User extends UnregisteredUser implements \JsonSerializable
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
     *      "unregisteredUser"="UnregisterUser"
     *   }
     * )
     */
    protected $followers;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Heartbeat")
     */
    protected $heartbeats;

    /**
     * @MongoDB\Int
     */
    protected $noHeartbeatTimeLimit;

    public function __construct()
    {
        $this->followers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->heartbeats = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param AreYou\StillThereBundle\Document\Heartbeat $heartbeats
     */
    public function addHeartbeats(\AreYou\StillThereBundle\Document\Heartbeat $heartbeats)
    {
        $this->heartbeats[] = $heartbeats;
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

    public function JsonSerialize()
    {
        return [
            'username'             => $this->username,
            'email'                => $this->email,
            'noHeartbeatTimeLimit' => $this->noHeartbeatTimeLimit,
            'lastHeartbeat'        => $this->getLastHeartbeat()->getDate()->getTimestamp(),
            ];
    }
}
