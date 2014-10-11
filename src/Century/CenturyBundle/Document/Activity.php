<?php

namespace Century\CenturyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class Activity
{

    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Int()
     */
    protected $ride_id;

    /**
     * @var float
     * @ODM\Distance()
     */
    protected $distance;

    /**
     * @ODM\Date
     */
    protected $date;

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
     * Set distance
     *
     * @param string $distance
     * @return self
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * Get distance
     *
     * @return string $distance
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set date
     *
     * @param date $date
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
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
     * Set user
     *
     * @param Century\CenturyBundle\Document\User $user
     * @return self
     */
    public function setUser(\Century\CenturyBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return Century\CenturyBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set rideId
     *
     * @param int $rideId
     * @return self
     */
    public function setRideId($rideId)
    {
        $this->ride_id = $rideId;
        return $this;
    }

    /**
     * Get rideId
     *
     * @return int $rideId
     */
    public function getRideId()
    {
        return $this->ride_id;
    }
}
