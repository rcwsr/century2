<?php

namespace Century\CenturyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $redis = $this->get('snc_redis.default');
        $strava = $this->get('strava');

        $athletes = $redis->get('athletes');
        if (!$athletes) {
            $athletes = $strava->get('clubs/369/members', '5cf019ce264d1ebe9725fbe7cb1ffbf9d5693ea4',
                ['per_page' => '200']);
            $redis->set('athletes', json_encode($athletes));
        }
        $athletes = \GuzzleHttp\json_decode($athletes);

        foreach ($athletes as $athlete) {
            $athlete->activities =  $strava->get('clubs/369/members', '5cf019ce264d1ebe9725fbe7cb1ffbf9d5693ea4',
                ['per_page' => '200']);
        }
        return $this->render('CenturyCenturyBundle:Default:index.html.twig');
    }
}
