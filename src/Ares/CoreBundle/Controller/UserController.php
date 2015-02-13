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


class UserController extends Controller {

    /**
     * @Route("/", name="user_task_index")
     */
    public function indexAction()
    {
        
        $currentUser= $this->get('security.context')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();

        

        $usertasks = $em->getRepository('AresCoreBundle:Usertask')->getUsertasksByUserId($currentUser);


        return $this->render('AresCoreBundle:User:index.html.twig', array(
            'usertasks' => $usertasks,
        ));

    }
    
} 