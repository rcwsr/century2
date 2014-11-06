<?php

namespace Century\CenturyBundle\Filter;

interface FilterInterface
{
    /**
     * @param array $activities
     * @return mixed
     */
    public function filter(array $activities);

    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options);
} 