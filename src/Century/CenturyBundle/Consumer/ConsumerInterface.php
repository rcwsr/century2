<?php


namespace Century\CenturyBundle\Consumer;


interface ConsumerInterface
{
    public function getActivities($token, \DateTime $from, \DateTime $to);
}