<?php

namespace Century\CenturyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {


        $repo = $this->get('doctrine_mongodb')->getRepository('CenturyCenturyBundle:User');

        //$user = $repo->find($this->getUser()->getId());

        $after = new \DateTime('2010-01-01');
        $beanstalk = $this->get("leezy.pheanstalk.primary");
        $beanstalk
            ->useTube('century.tube.activities')
            ->put(json_encode([
                'from' => $after->getTimestamp(),
                'to' => time(),
                'key' => $this->get('security.context')->getToken()->getAccessToken(),
            ]));



        return $this->render('CenturyCenturyBundle:Default:index.html.twig');
    }
}
