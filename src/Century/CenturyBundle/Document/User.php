<?php

namespace Century\CenturyBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ODM\Document
 */
class User implements UserInterface
{

    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @var int
     *
     * @ODM\Int
     * @ODM\Index(unique=true)
     */
    protected $stravaId;

    /**
     * @var string
     * @ODM\String
     */
    protected $firstname;

    /**
     * @var string
     * @ODM\String
     */
    protected $lastname;

    /**
     * @var string
     * @ODM\String
     */
    protected $profilePicture;

    /**
     * @var string
     * @ODM\String
     */
    protected $city;

    /**
     * @var string
     * @ODM\String
     */
    protected $state;

    /**
     * @var string
     * @ODM\String
     */
    protected $country;

    /**
     * @var string
     * @ODM\String
     */
    protected $sex;

    /**
     * @var string
     * @ODM\String
     */
    protected $measurement;

    /**
     * @var string
     * @ODM\String
     */
    protected $email;

    /**
     * @var Club[]
     * @ODM\ReferenceMany(targetDocument="Century\CenturyBundle\Document\Club", cascade={"all"})
     */
    protected $clubs;

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function equals(UserInterface $user)
    {
        return $user->getUsername() === $this->getUsername();
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return array('ROLE_USER', 'ROLE_OAUTH_USER');
    }
    
    /**
     * Set firstname
     *
     * @param string $firstname
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return self
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get state
     *
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return self
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return self
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     * Get sex
     *
     * @return string $sex
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set measurement
     *
     * @param string $measurement
     * @return self
     */
    public function setMeasurement($measurement)
    {
        $this->measurement = $measurement;
        return $this;
    }

    /**
     * Get measurement
     *
     * @return string $measurement
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
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
     * Set profilePicture
     *
     * @param string $profilePicture
     * @return self
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profile_picture = $profilePicture;
        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return string $profilePicture
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function __toString()
    {
        return $this->firstname;
    }

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }

    /**
     * Get internalId
     *
     * @return id $internalId
     */
    public function getInternalId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     * @return self
     */
    public function setStravaId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return int $id
     */
    public function getStravaId()
    {
        return $this->id;
    }

    /**
     * Add club
     *
     * @param Club $club
     */
    public function addClub(Club $club)
    {
        $this->clubs[] = $club;
    }

    /**
     * Remove club
     *
     * @param Club $club
     */
    public function removeClub(Club $club)
    {
        $this->clubs->removeElement($club);
    }

    /**
     * Get clubs
     *
     * @return Collection $clubs
     */
    public function getClubs()
    {
        return $this->clubs;
    }
}
