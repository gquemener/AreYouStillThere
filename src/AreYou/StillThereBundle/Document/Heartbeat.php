<?php

namespace AreYou\StillThereBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="heartbeats")
 */
class Heartbeat implements \JsonSerializable
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

    public function setUser(\AreYou\StillThereBundle\Document\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function jsonSerialize()
    {
        return [
            'd' => $this->getDate()->getTimestamp(),
            'm' => $this->getMessage(),
            'u' => $this->getUser()->getUsername(),
        ];
    }
}
