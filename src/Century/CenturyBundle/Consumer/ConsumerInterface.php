<?php


namespace Century\CenturyBundle\Consumer;


use Symfony\Component\Security\Core\User\UserInterface;

interface ConsumerInterface
{
    /**
     * Gets the currently logged in user's clubs
     *
     * @param $token
     * @return mixed
     */
    public function getClubs($token);

    /**
     * Gets the currently logged in user's activities
     *
     * @param $token
     * @param \DateTime $from
     * @param \DateTime $to
     * @param UserInterface $user
     * @return mixed
     */
    public function getActivities($token, \DateTime $from, \DateTime $to, UserInterface $user);
}