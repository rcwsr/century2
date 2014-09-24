<?php

namespace Century\CenturyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CenturyCenturyBundle:Default:index.html.twig');
    }
}
