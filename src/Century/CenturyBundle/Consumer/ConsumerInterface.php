<?php


namespace Century\CenturyBundle\Consumer;


use Symfony\Component\Security\Core\User\UserInterface;

interface ConsumerInterface
{
    public function getActivities($token, \DateTime $from, \DateTime $to, UserInterface $user);
}