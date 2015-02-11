<?php
namespace Ares\CoreBundle\Controller;
use Ares\CoreBundle\Entity\Chronometer;
use Ares\CoreBundle\Entity\Usertask;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ChronometerController extends Controller
{
    /**
     * @Route("/start", name="chronometer_start")
     */
    public function startAction(Request $request)
    {
        // Récupere l'entity manager
        $em = $this->getDoctrine()->getManager();

        // Récupere la task id
        $taskId = (int) $request->request->get('taskId');

        // Récupere l'utilisateur courrant
        $currentUser= $this->get('security.context')->getToken()->getUser()->getId();

        // Récupere le usertask
        $currentUsertask = $em->getRepository('AresCoreBundle:Usertask')->myFindByUserAndTask($currentUser,$taskId);

        // Créé un nouveau chrono avec l'id du bon usertask
        $chronometer = new chronometer();
        $chronometer->setUsertask($currentUsertask[0]);

        // Enregistre la usertask
        $em->persist($chronometer);
        $em->flush();

        $response = array("code" => 200, "success" => true, "data" => $taskId);
        return new Response(json_encode($response));
    }


    /**
     * @Route("/update", name="chronometer_update")
     */
    public function updateAction(Request $request)
    {
        // Récupere l'entity manager
        $em = $this->getDoctrine()->getManager();

        // Récupere la task id
        $taskId = (int) $request->request->get('taskId');

        // Récupere l'utilisateur courrant
        $currentUser= $this->get('security.context')->getToken()->getUser();

        // Récupere la derniere usertask avec la task et l'utilistateur courrant
        $chronometerRepository = $em->getRepository('AresCoreBundle:Chronometer');
        $chronometer = $chronometerRepository->myFindChronometerByUserAndTask($currentUser->getId(), $taskId)[0];

        // Update la date de fin
        $chronometer->setStopdate(new \Datetime());
        // Persiste
        $em->persist($chronometer);
        $em->flush();

        //reponse
        $response = array("code" => 200, "success" => true, "data" => 'data');
        return new Response(json_encode($response));
    }

    /**
     * Retourne le temps travailler par tache
     * @Route("/timespent/{id}", name="chronometer_timespent")
     */
    public function timeSpentByTaskAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();

        $chronometerRepository = $em->getRepository('AresCoreBundle:Chronometer');        
        $chronometers = $chronometerRepository->myFindByTask($id);
        
        $currentUser= $this->get('security.context')->getToken()->getUser();
        
//        dump($currentUser->getId());

        $connectedUserTimeSpent = 0;
        foreach ($chronometers as $chronometer) {
            $idUserTask = $chronometer->getUsertask()->getUser()->getId();
            if ($idUserTask == $currentUser->getId()) {
                $connectedUserTimeSpent += $chronometer->getStopDate()->getTimeStamp() - $chronometer->getStartDate()->getTimeStamp();
            }
            
//            dump($chronometer->getStopDate());
        }
        
//        die;
        
        $timespent = 0;
        foreach ($chronometers as $chronometer) {
            $timespent+= $chronometer->getStopdate()->getTimestamp() - $chronometer->getStartdate()->getTimestamp();
        }
        
        $infosTimeSpent = array(
            'perso' => $connectedUserTimeSpent,
            'total' => $timespent
        );
        
        // Si la requête est une requête AJAX
        if ($request->isXmlHttpRequest()) {
          $response = array("code" => 200, "success" => true, "timespent" => $infosTimeSpent);
          return new Response(json_encode($response));      
        } else {
          
          $datetime = $this->container->get('ares_core.datetime');     
          
          return new Response($datetime->secondsToTime($timespent));
        }
        
        
        
        

    }
    

    /**
     * Retourne le temps travailler par tache
     * @Route("/test", name="test")
     */
    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chronometerRepository = $em->getRepository('AresCoreBundle:Chronometer');

        $chronometers = $chronometerRepository->myFindByTask(3);

        $timespent = 0;
        foreach ($chronometers as $chronometer) {
            $timespent+= $chronometer->getStopdate()->getTimestamp() - $chronometer->getStartdate()->getTimestamp();

        }


        echo '<pre>';
        \Doctrine\Common\Util\Debug::dump($timespent);
        echo '</pre>';
        die();


    }

}