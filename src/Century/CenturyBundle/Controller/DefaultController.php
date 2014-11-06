<?php

namespace Century\CenturyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $from = new \DateTime('2014-01-01');
        $beanstalk = $this->get("leezy.pheanstalk.primary");
        $beanstalk
            ->useTube('century.tube.activities')
            ->put(json_encode([
                'from' => $from->getTimestamp(),
                'to' => time(),
                'token' => $this->get('security.context')->getToken()->getAccessToken(),
                'user' => $this->getUser()->getInternalId(),
            ]));

        return $this->render('CenturyCenturyBundle:Default:index.html.twig');
    }

    public function ridesAction()
    {
        $om = $this->get('doctrine.odm.mongodb.document_manager');
        $repo = $om->getRepository('CenturyCenturyBundle:Activity');
        $user_repo = $om->getRepository('CenturyCenturyBundle:User');

//        $user = $user_repo->findOneBy(['internal_id' => '545a401810f0ed04048b4567']);
//        var_dump($user->getId());
//        $rides = $repo->findBy(['user.internal_id' => $this->getUser()->getInternalId()]);
        $rides = $repo->findAll();

        foreach($rides as $ride){
//           var_dump($ride->getUser()->getInternalId());
            $om->remove($ride);
        }
        $om->flush();

        //$rides = $this->getUser()->getActivities();
        var_dump(count($rides));die;
    }
}
