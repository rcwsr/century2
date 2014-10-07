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
     * @param ClientInterface $http
     * @param SecurityContextInterface $context
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
            $request = $this->getActivitiesPage($token, $from, $to, $page++, 200);
            if(count($request) == 0){
                $entries = false;
            }

            foreach($request as $activity){
                $activities[] = $activity;
            }
        }

        return $activities;
    }

    private function getActivitiesPage($token, \DateTime $from, \DateTime $to, $page, $per_page)
    {
        $get = $this->http->get(self::API_URL . 'athlete/activities', [
            'query' => [
                'access_token' => $token,
                'before' => $from->getTimestamp(),
                'after' => $to->getTimestamp(),
                'per_page' => $per_page,
                'page' => $page
            ]
        ]);

        return $get->json();
    }
}
