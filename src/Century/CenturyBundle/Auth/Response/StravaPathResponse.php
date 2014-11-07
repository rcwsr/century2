<?php

namespace Century\CenturyBundle\Auth\Response;


use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;

class StravaPathResponse extends PathUserResponse
{
    public function getSex()
    {
        return $this->getValueForPath('sex');
    }

    public function getCity()
    {
        return $this->getValueForPath('city');
    }

    public function getState()
    {
        return $this->getValueForPath('state');
    }

    public function getCountry()
    {
        return $this->getValueForPath('country');
    }

    public function getMeasurement()
    {
        return $this->getValueForPath('measurement');
    }

    public function getFirstname()
    {
        return $this->getValueForPath('firstname');
    }

    public function getLastname()
    {
        return $this->getValueForPath('lastname');
    }

    public function getClubs()
    {
        return $this->getValueForPath('clubs');
    }



} 