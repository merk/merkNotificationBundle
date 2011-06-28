<?php

namespace merk\NotificationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('merkNotificationsBundle:Default:index.html.twig', array('name' => $name));
    }
}
