<?php

namespace Century\CenturyBundle\Filter;

interface FilterInterface
{
    /**
     * @return array
     */
    public function filter();

    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options);

    /**
     * @param array $activities
     * @return self
     */
    public function setActivities(array $activities);
} 