<?php

namespace AreYou\StillThereBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="heartbeats")
 * @MongoDB\Index(keys={"location"="2d"})
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
     * @MongoDB\EmbedOne(targetDocument="Coordinates")
     */    
    protected $location;

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
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set location
     *
     * @param AreYou\StillThereBundle\Document\Coordinates $location
     */
    public function setLocation(\AreYou\StillThereBundle\Document\Coordinates $location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return AreYou\StillThereBundle\Document\Coordinates $location
     */
    public function getLocation()
    {
        return $this->location;
    }
}
