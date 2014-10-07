<?php


namespace Century\CenturyBundle\Consumer;


interface ConsumerInterface {

    public function getActivities($after, $before);
} 