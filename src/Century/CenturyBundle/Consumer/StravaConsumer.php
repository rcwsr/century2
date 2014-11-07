<?php

namespace Century\CenturyBundle\Consumer;

use Buzz\Client\ClientInterface;
use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Document\Club;
use Century\CenturyBundle\Document\User;
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

        while ($entries) {

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

            if (count($response) == 0) {
                $entries = false;
            }

            foreach ($response as $activity_raw) {
                $activities[] = $this->createActivity($user, $activity_raw);
            }
        }

        return $activities;
    }

    /**
     * @param $user
     * @param $activity_raw
     * @return Activity
     */
    private function createActivity($user, $activity_raw)
    {
        $activity = new Activity();
        $activity
            ->setId($activity_raw['id'])
            ->setDate(new \DateTime($activity_raw['start_date']))
            ->setDistance($activity_raw['distance'])
            ->setUser($user);

        return $activity;
    }

    /**
     * @param $token
     * @return array
     */
    public function getClubs($token)
    {
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $response = $this->http->get(self::API_URL . 'athlete/clubs', [
            'query' => [
                'access_token' => $token,
            ]
        ])->json();
        
        $clubs = [];
        foreach ($response as $club_raw) {
            $clubs[] = $this->createClub($club_raw);
        }

        return $clubs;
    }

    /**
     * @param $club_raw
     * @return Club
     */
    private function createClub($club_raw)
    {
        $club = new Club();
        $club
            ->setId($club_raw['id'])
            ->setName($club_raw['name'])
            ->setProfilePicture($club_raw['profile']);

        return $club;
    }
}
