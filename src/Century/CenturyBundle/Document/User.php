<?php

namespace Century\CenturyBundle\Document;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Security\Core\Role\Role;
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
    protected $strava_id;

    /**
     * @var string
     * @ODM\String
     */
    protected $realname;

    /**
     * @var string
     * @ODM\String
     */
    protected $nickname;

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
     * Set stravaId
     *
     * @param int $stravaId
     * @return self
     */
    public function setStravaId($stravaId)
    {
        $this->strava_id = $stravaId;
        return $this;
    }

    /**
     * Get stravaId
     *
     * @return int $stravaId
     */
    public function getStravaId()
    {
        return $this->strava_id;
    }

    /**
     * Set realname
     *
     * @param string $realname
     * @return self
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;
        return $this;
    }

    /**
     * Get realname
     *
     * @return string $realname
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     * @return self
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * Get nickname
     *
     * @return string $nickname
     */
    public function getNickname()
    {
        return $this->nickname;
    }

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
        return $this->strava_id;
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
        return $user->getUsername() === $this->strava_id;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return array('ROLE_USER', 'ROLE_OAUTH_USER');
    }
}
