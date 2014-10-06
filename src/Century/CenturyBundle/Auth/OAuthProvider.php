<?php

namespace Century\CenturyBundle\Auth;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Century\CenturyBundle\Document\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;

class OAuthProvider extends OAuthUserProvider
{
    protected $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function loadUserByUsername($username)
    {
        $user_repo = $this->om->getRepository('CenturyCenturyBundle:User');
        $user = $user_repo->findOneBy(['strava_id' => $username]);

        if($user){
            return $user;
        }
        else{
            return new User();
        }
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user_repo = $this->om->getRepository('CenturyCenturyBundle:User');
        $user = $user_repo->findOneBy(['strava_id' => $response->getUserName()]);

        if($user){
            return $user;
        }
        else{
            $user = new User();
            $user
                ->setNickname($response->getNickname())
                ->setRealname($response->getRealName())
                ->setStravaId($response->getUsername());
            $this->om->persist($user);
            $this->om->flush();
        }

        return $this->loadUserByUsername($user->getUsername());
    }


    public function supportsClass($class)
    {
        return $class === 'Century\CenturyBundle\Document\User';
    }
}