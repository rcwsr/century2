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
    protected $id;

    /**
     * @ODM\Int()
     */
    protected $stravaId;

    /**
     * @var string
     * @ODM\String
     */
    protected $name;

    /**
     * @var string
     * @ODM\String
     */
    protected $profilPicture;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getProfilPicture()
    {
        return $this->profilPicture;
    }

    /**
     * @param string $profilPicture
     */
    public function setProfilPicture($profilPicture)
    {
        $this->profilPicture = $profilPicture;
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
