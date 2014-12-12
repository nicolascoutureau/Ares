<?php
namespace Ares\CoreBundle\Controller;
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

        // Récupere la tache
        $task = $em->getRepository('AresCoreBundle:Task')->findOneById($taskId);

        // Récupere l'utilisateur courrant
        $currentUser= $this->get('security.context')->getToken()->getUser();

        // Créé une nouvelle usertask
        $usertask = new usertask();
        $usertask->setUser($currentUser)
                 ->setTask($task);

        // Enregistre la usertask
        $em->persist($usertask);
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
        $usertaskRepository = $em->getRepository('AresCoreBundle:Usertask');
        $usertask = $usertaskRepository->findBy
            (array('task' => $taskId,'user'=>$currentUser->getId()),
            array('startdate' => 'desc'),
            1,
            0)[0];

        // Update la date de fin
        $usertask->setStopdate(new \Datetime());

        // Persiste
        $em->persist($usertask);
        $em->flush();

        //reponse
        $response = array("code" => 200, "success" => true, "data" => 'data');
        return new Response(json_encode($response));
    }


    /**
     * Retourne le temps travailler par tache
     * @Route("/timespent/{id}", name="chronometer_timespent")
     */
    public function timeSpentByTaskAction($id){

        $em = $this->getDoctrine()->getManager();

        $usertaskRepository = $em->getRepository('AresCoreBundle:Usertask');
        $usertasks = $usertaskRepository->findByTask($id);

        $timespent = 0;
        foreach($usertasks as $usertask){
           $timespent+= $usertask->getStopdate()->getTimestamp() - $usertask->getStartdate()->getTimestamp();
        }

        // Réponse
        $response = array("code" => 200, "success" => true, "timespent" => $timespent);
        return new Response(json_encode($response));
    }

}