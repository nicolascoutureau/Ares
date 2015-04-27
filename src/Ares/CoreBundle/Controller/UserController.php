<?php

/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/11/2014
 * Time: 12:06
 */

namespace Ares\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ares\CoreBundle\Entity\Usertask;

class UserController extends Controller
{

  /**
   * @Route("/", name="user_task_index")
   */
  public function indexAction()
  {
    $currentUser = $this->get('security.context')->getToken()->getUser();
    $em = $this->getDoctrine()->getManager();

    $usertasks = $em->getRepository('AresCoreBundle:Usertask')->getUsertasksByUserId($currentUser);

    $arrayIdTask = array();
    foreach ($usertasks as $utPerso) {
      $arrayIdTask[] = $utPerso[0]->getTask()->getId();
    }

    $usertasks4FullTime = $em->getRepository('AresCoreBundle:Usertask')->req2($arrayIdTask);

    foreach ($usertasks as $key => $value) {
      $usertasks[$key]['totaltime'] = $usertasks4FullTime[$key]['totaltime'];
    }

    return $this->render('AresCoreBundle:User:index.html.twig', array(
                'usertasks' => $usertasks,
    ));
  }

}
