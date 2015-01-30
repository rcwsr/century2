<?php

namespace Century\CenturyBundle\Consumer;

use Century\CenturyBundle\Document\Activity;
use Century\CenturyBundle\Document\Club;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use JMS\Serializer\Serializer;
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
     * @var Serializer
     */
    private $serializer;


    /**
     * @param Client|ClientInterface $http
     * @param Serializer $serializer
     */
    public function __construct(ClientInterface $http, Serializer $serializer)
    {
        $this->http = $http;
        $this->serializer = $serializer;
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

            foreach ($response as $activityRaw) {
                $activities[] = $this->createActivity($user, $activityRaw);
            }
        }

        return $activities;
    }

    /**
     * @param $user
     * @param $activity_raw
     * @return Activity
     */
    private function createActivity($user, $activityRaw)
    {
//        $activity = new Activity();
//        $activity
//            ->setId($activity_raw['id'])
//            ->setDate(new \DateTime($activity_raw['start_date']))
//            ->setDistance($activity_raw['distance'])
//            ->setUser($user);

        return $this->serializer->deserialize($activityRaw, 'Century\CenturyBundle\Document\Activity', 'array');
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
