<?php

namespace Century\CenturyBundle\Auth;


use Century\CenturyBundle\Document\User;
use Doctrine\Common\Persistence\ObjectManager;
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

        if ($user) {
            return $user;
        } else {
            return new User();
        }
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {

        $user_repo = $this->om->getRepository('CenturyCenturyBundle:User');
        $user = $user_repo->findOneBy(['strava_id' => $response->getUserName()]);

        if ($user) {
            $user = $this->assignUserProperties($user, $response);
            //return $user;
        } else {
            $user = new User();
            $user->setStravaId($response->getUsername());
            $user = $this->assignUserProperties($user, $response);


        }
        $this->om->persist($user);
        $this->om->flush();

        return $this->loadUserByUsername($user->getUsername());
    }


    public function assignUserProperties($user, $response)
    {
        $user
            ->setProfilePicture($response->getProfilePicture())
            ->setFirstname($response->getFirstname())
            ->setLastname($response->getLastname())
            ->setSex($response->getSex())
            ->setEmail($response->getEmail())
            ->setCity($response->getCity())
            ->setState($response->getState())
            ->setCountry($response->getCountry())
            ->setMeasurement($response->getMeasurement())
        ;
        return $user;
    }


    public function supportsClass($class)
    {
        return $class === 'Century\CenturyBundle\Document\User';
    }
}