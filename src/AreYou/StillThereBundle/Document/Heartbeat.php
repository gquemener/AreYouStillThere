<?php

namespace AreYou\StillThereBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="heartbeats")
 */
class Heartbeat
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Date
     */
    protected $date;

    /**
     * @MongoDB\String
     */
    protected $message;

    /**
     * @MongoDB\ReferenceOne(targetDocument="User", inversedBy="heartbeats")
     */
    protected $user;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setLocation(\AreYou\StillThereBundle\Document\Coordinates $location)
    {
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setUser(\AreYou\StillThereBundle\Document\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
