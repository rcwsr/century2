<?php

namespace Century\CenturyBundle\Document;

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
    protected $internal_id;

    /**
     * @var int
     *
     * @ODM\Int
     * @ODM\Index(unique=true)
     */
    protected $id;

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
    protected $profile_picture;

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
        return $this->profile_picture;
    }

    public function __toString()
    {
        return $this->firstname;
    }

    public function __construct(){}

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
}
