<?php

namespace Century\CenturyBundle\Document;

use Century\CenturyBundle\Document\User;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class Activity
{

    /**
     * @ODM\Id
     */
    protected $internal_id;

    /**
     * @ODM\Int()
     */
    protected $id;

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
     * @var User
     * @ODM\ReferenceOne(targetDocument="Century\CenturyBundle\Document\User")
     */
    protected $user;


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
     * @param \DateTime $date $date
     * @return self
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return User $user
     */
    public function getUser()
    {
        return $this->user;
    }



    /**
     * Get internalId
     *
     * @return id $internalId
     */
    public function getInternalId()
    {
        return $this->internal_id;
    }

    /**
     * Set internal id
     *
     * @param int $id
     * @return self
     */
    public function setInternalId($id)
    {
        $this->internal_id = $id;
        return $this;
    }

    /**
     * Set id
     *
     * @param int $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    public function hash()
    {
        return md5(sprintf('%d_%d', $this->id, $this->distance));
    }

    public function equals(Activity $activity)
    {
        return $activity->hash() === $this->hash();
    }

    public function __toString()
    {
        return $this->hash();
    }
}
