<?php

namespace Century\CenturyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {


        $repo = $this->get('doctrine_mongodb')->getRepository('CenturyCenturyBundle:User');

        //$user = $repo->find($this->getUser()->getId());

        $from = new \DateTime('2010-01-01');
        $beanstalk = $this->get("leezy.pheanstalk.primary");
        $beanstalk
            ->useTube('century.tube.activities')
            ->put(json_encode([
                'from' => $from->getTimestamp(),
                'to' => time(),
                'token' => $this->get('security.context')->getToken()->getAccessToken(),
            ]));

        $consumer = $this->get('century.consumer.strava');
//        $activities = $consumer->getActivities($this->get('security.context')->getToken()->getAccessToken(), $from, \DateTime::createFromFormat('U', time()));
//        var_dump($activities);
        return $this->render('CenturyCenturyBundle:Default:index.html.twig');
    }
}
