<?php

namespace Century\CenturyBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $strava;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\OneToMany(targetEntity="Century\CenturyBundle\Entity\Ride", mappedBy="user")
     */
    private $rides;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $metric;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set strava
     *
     * @param string $strava
     * @return User
     */
    public function setStrava($strava)
    {
        $this->strava = $strava;

        return $this;
    }

    /**
     * Get strava
     *
     * @return string 
     */
    public function getStrava()
    {
        return $this->strava;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return User
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rides = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add rides
     *
     * @param \Century\CenturyBundle\Entity\Ride $rides
     * @return User
     */
    public function addRide(\Century\CenturyBundle\Entity\Ride $rides)
    {
        $this->rides[] = $rides;

        return $this;
    }

    /**
     * Remove rides
     *
     * @param \Century\CenturyBundle\Entity\Ride $rides
     */
    public function removeRide(\Century\CenturyBundle\Entity\Ride $rides)
    {
        $this->rides->removeElement($rides);
    }

    /**
     * Get rides
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRides()
    {
        return $this->rides;
    }
}
