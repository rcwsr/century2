<?php

namespace Century\CenturyBundle\Consumer;

use Buzz\Client\ClientInterface;
use GuzzleHttp\Client;
use Symfony\Component\Security\Core\SecurityContextInterface;

class StravaConsumer implements ConsumerInterface
{
    /**
     * @var ClientInterface
     */
    private $http;

    const API_URL = 'https://www.strava.com/api/v3/';


    /**
     * @param Client $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * Gets the activities of the currently authorised strava user
     *
     * @return array
     */
    public function getActivities($token, \DateTime $from, \DateTime $to)
    {
        $activities = [];
        $page = 1;
        $entries = true;

        while($entries){

            $response = $this->http->get(self::API_URL . 'athlete/activities', [
                'query' => [
                    'access_token' => $token,
                    'after' => $from->getTimestamp(),
                    'before' => $to->getTimestamp(),
                    'per_page' => 200,
                    'page' => $page++
                ]
            ])->json();

            if(count($response) == 0){
                $entries = false;
            }

            foreach($response as $activity){
                $activities[] = $activity;
            }
        }

        return $activities;
    }
}
