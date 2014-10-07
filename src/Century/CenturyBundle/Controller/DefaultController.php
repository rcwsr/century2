<?php

namespace Century\CenturyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {


        $repo = $this->get('doctrine_mongodb')->getRepository('CenturyCenturyBundle:User');

        //$user = $repo->find($this->getUser()->getId());



        $consumer = $this->get('century.consumer.strava');

        $after = new \DateTime('2010-01-01');
        var_dump($consumer->getActivities($after->getTimestamp(), time()));
        //var_dump($repo->findAll());
        return $this->render('CenturyCenturyBundle:Default:index.html.twig');
    }
}
