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
    /**
     * @var SecurityContextInterface
     */
    private $context;

    const API_URL = 'https://www.strava.com/api/v3/';


    /**
     * @param ClientInterface $http
     * @param SecurityContextInterface $context
     */
    public function __construct(Client $http, SecurityContextInterface $context)
    {
        $this->http = $http;
        $this->context = $context;
    }

    /**
     * Gets the activities of the currently authorised strava user
     *
     * @return array
     */
    public function getActivities($after, $before)
    {
        $activities = [];
        $page = 1;
        $entries = true;

        while($entries){
            $request = $this->getActivitiesPage($after, $before, $page++, 200);
            if(count($request) == 0){
                $entries = false;
            }

            foreach($request as $activity){
                $activities[] = $activity;
            }
        }

        return $activities;
    }

    private function getActivitiesPage($after, $before, $page, $per_page)
    {
        $get = $this->http->get(self::API_URL . 'athlete/activities', [
            'query' => [
                'access_token' => $this->context->getToken()->getAccessToken(),
                'before' => $before,
                'after' => $after,
                'per_page' => $per_page,
                'page' => $page
            ]
        ]);

        return $get->json();
    }
}
