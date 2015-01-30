<?php

namespace Century\CenturyBundle\Document;

use Century\CenturyBundle\Document\User;
use Century\CenturyBundle\Sync\Model\SynchronizableInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class Activity implements SynchronizableInterface
{

    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Int()
     */
    protected $stravaId;

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
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStravaId()
    {
        return $this->stravaId;
    }

    /**
     * @param mixed $stravaId
     */
    public function setStravaId($stravaId)
    {
        $this->stravaId = $stravaId;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function hash()
    {
        return md5(sprintf('%d_%d', $this->id, $this->distance));
    }

    public function equals(SynchronizableInterface $activity)
    {
        return $activity->hash() === $this->hash();
    }

    public function __toString()
    {
        return $this->hash();
    }
}
