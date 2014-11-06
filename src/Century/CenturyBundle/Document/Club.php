<?php

namespace Century\CenturyBundle\Document;

use Century\CenturyBundle\Sync\Model\SynchronizableInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class Club implements SynchronizableInterface
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
     * @var string
     * @ODM\String
     */
    protected $name;

    /**
     * @var string
     * @ODM\String
     */
    protected $profile_picture;


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

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
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

    public function hash()
    {
        return md5(sprintf('%d_%s_%s', $this->id, $this->name, $this->profile_picture));
    }

    public function equals(SynchronizableInterface $club)
    {
        return $club->hash() === $this->hash();
    }

    public function __toString()
    {
        return $this->hash();
    }
}
