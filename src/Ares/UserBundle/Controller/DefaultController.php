<?php

namespace Ares\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AresUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
