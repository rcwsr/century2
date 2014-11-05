<?php

namespace Century\CenturyBundle\Consumer;

use Buzz\Client\ClientInterface;
use Century\CenturyBundle\Document\Activity;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param $token
     * @param \DateTime $from
     * @param \DateTime $to
     * @param UserInterface $user
     * @return array
     */
    public function getActivities($token, \DateTime $from, \DateTime $to, UserInterface $user)
    {
        $activities = [];
        $page = 1;
        $entries = true;

        while($entries){

            /** @noinspection PhpVoidFunctionResultUsedInspection */
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

            foreach($response as $activity_raw){
                $activity = new Activity();
                $activity
                    ->setId($activity_raw['id'])
                    ->setDate(new \DateTime($activity_raw['start_date']))
                    ->setDistance($activity_raw['distance'])
                    ->setUser($user);

                $activities[] = $activity;
            }
        }

        return $activities;
    }
}
