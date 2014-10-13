<?php

namespace Century\CenturyBundle\Filter;

interface FilterInterface
{
    /**
     * @param array $activities
     * @return array
     */
    public function filter(array $activities);

    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options);
} 