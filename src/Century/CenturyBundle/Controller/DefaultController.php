<?php

namespace Century\CenturyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $from = new \DateTime('2014-01-01');
        $beanstalk = $this->get("leezy.pheanstalk.primary");
//        $beanstalk
//            ->useTube('century.tube.activities')
//            ->put(json_encode([
//                'from' => $from->getTimestamp(),
//                'to' => time(),
//                'token' => $this->get('security.context')->getToken()->getAccessToken(),
//                'user' => $this->getUser()->getInternalId(),
//            ]));

        return $this->render('CenturyCenturyBundle:Default:index.html.twig');
    }

    public function ridesAction()
    {

    }

    public function clubsAction()
    {
        $this->processClubs();

        $om = $this->get('doctrine.odm.mongodb.document_manager');
        $repo = $om->getRepository('CenturyCenturyBundle:Club');
        //$repo = $om->getRepository('CenturyCenturyBundle:Activity');
        $clubs = $repo->findAll();
        $user_clubs = $this->getUser()->getClubs();
        foreach($clubs as $club){
            var_dump($club->getInternalId());
            //$om->remove($club);
        }

        echo "<br><br>User: ";
        foreach($user_clubs as $club){
            var_dump($club->getInternalId());
        //    $om->remove($club);
        }

        //$om->remove($this->getUser());
        //$om->flush();


        die;
    }

    private function processClubs()
    {
        //$om = $this->get('doctrine.odm.mongodb.document_manager');
        //$repo = $om->getRepository('CenturyCenturyBundle:Club');
        //$existing_clubs = $repo->findBy(['user.internal_id' => $this->getUser()->getInternalId()]);

        $existing_clubs = $this->getUser()->getClubs()->toArray();
        $token = $this->get('security.context')->getToken()->getAccessToken();

        $consumer = $this->get('century.consumer.strava');
        $clubs = $consumer->getClubs($token);

        $processor = $this->get('century.processor.club');
        $processor->setUser($this->getUser());
        $clubs = $processor->process($existing_clubs, $clubs);

        return $clubs;
    }
}
