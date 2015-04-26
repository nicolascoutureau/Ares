<?php

namespace Ares\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ares\CoreBundle\Entity\Task;
use Ares\CoreBundle\Form\TaskType;

class AdminController extends Controller
{

    /**
     * @Route("/tasks", name="admin_task_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tasks = $em->getRepository('AresCoreBundle:Task')->findBy(array(), array('deadline' => 'ASC'));

        return $this->render('AresCoreBundle:Admin:index.html.twig', array(
            'tasks' => $tasks
        ));
    }

    /**
     * @Route("/task/new", name="admin_task_new")
     */
    public function newAction()
    {
        $entity = new Task();
        $form = $this->createCreateForm($entity);
        return $this->render('AresCoreBundle:Task:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/task/create", name="admin_task_create")
     */
    public function createAction(Request $request)
    {
        $entity = new Task();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success', 'La tache a bien été ajoutée!'
            );
            return $this->redirect($this->generateUrl('admin_task_index'));
        }
        return $this->render('AresCoreBundle:Task:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Task entity.
     *
     * @param Task $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Task $entity)
    {
        $form = $this->createForm(new TaskType(), $entity, array(
            'action' => $this->generateUrl('admin_task_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * @Route("/task/{id}/edit", name="admin_task_edit")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AresCoreBundle:Task')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('AresCoreBundle:Task:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Task entity.
     *
     * @param Task $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Task $entity)
    {
        $form = $this->createForm(new TaskType(), $entity, array(
            'action' => $this->generateUrl('admin_task_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Update'));
        return $form;
    }

    /**
     * @Route("/task/{id}/update", name="admin_task_update")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entityTask = $em->getRepository('AresCoreBundle:Task')->find($id);

        if (!$entityTask) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        $editForm = $this->createEditForm($entityTask);
        $deleteForm = $this->createDeleteForm($id);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            //Gere l'assignation
            $postArray = $request->request->get('ares_corebundle_task');
            $selectedUsers = $postArray['users'];
            $usertasks = $entityTask->getUsertasks();

            foreach ($usertasks as $usertask) {
                if ($usertask->getId() !== null) {
                    $user = $usertask->getUser();
                    if (in_array($user->getId(), $selectedUsers)) {
                        $usertask->setAssignation(true);
                    } else {
                        $usertask->setAssignation(false);
                    }
                }
            }

            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success', 'La tache a bien été modifée!'
            );
            return $this->redirect($this->generateUrl('admin_task_edit', array('id' => $id)));
        }

        return $this->render('AresCoreBundle:Task:edit.html.twig', array(
            'entity' => $entityTask,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/task/{id}/delete", name="admin_task_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AresCoreBundle:Task')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Task entity.');
            }
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice', 'La tache a bien été supprimée!'
            );
        }
        return $this->redirect($this->generateUrl('admin_task_index'));
    }

    /**
     * Creates a form to delete a Task entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_task_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * @Route("/historical/week", name="admin_histo_week")
     */
    public function histoByWeekAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tasks = $em->getRepository('AresCoreBundle:Task')->findAll();

        return $this->render('AresCoreBundle:Historical:week.html.twig', array(
            'tasks' => $tasks
        ));
    }

    /**
     * @Route("/historical/users/{id}", name="admin_histo_users")
     */
    public function histoByUserAction(Request $request, $id = 0)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id == 0) {
            $users = $em->getRepository('AresUserBundle:User')->findAll();

            return $this->render('AresCoreBundle:Historical:users.html.twig', array(
                'users' => $users,
                'userId' => $id
            ));
    } else {
        $user = $em->getRepository('AresUserBundle:User')->find($id);
        $jsonGantt = array("data" => array(), "links" => array());
        $i = $j = $k = 0;
        foreach ($user->getUsertasks() as $UserTask) {
            $i = $j;
            $i++;
            $Task = $UserTask->getTask();
            $datecreated = $Task->getDatecreated();
            $deadline = $Task->getDeadline();
            $jsonGantt['data'][] = array(
                "id" => $i,
                "text" => $Task->getName(),
                "start_date" => $datecreated->format('Y-m-d H:i'),
                "duration" => $datecreated->diff($deadline)->format('%a'),
                "progress" => "1",
                "open" => "true"
            );
            
            $j = $i;
            foreach ($UserTask->getChronometers() as $Chrono) {
                $j++;
                $startdate = $Chrono->getStartdate();
                $stopdate = $Chrono->getStopdate();
                $jsonGantt['data'][] = array(
                    "id" => $j,
                    "text" => $Task->getName() . $j,
                    "start_date" => $startdate->format('Y-m-d H:i'),
                    "duration" => $startdate->diff($stopdate)->format('%a'),
                    "progress" => "1",
                    "open" => "true",
                    "parent" => $i
                );
                $k++;
                $jsonGantt['links'][] = array(
                    "id" => $k,
                    "source" => $i,
                    "target" => $j,
                    "type" => "1"
                );
            }
        }
        
        // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
        $response = new Response(json_encode($jsonGantt));
        
        // Ici, nous définissons le Content-type pour dire au navigateur
        // que l'on renvoie du JSON et non du HTML
        $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }

  /**
   * @Route("/historical/tasks/{id}", name="admin_histo_tasks")
   */
  public function histoByTaskAction(Request $request, $id = 0)
  {
    $em = $this->getDoctrine()->getManager();
    
    if ($id == 0) {
        $tasks = $em->getRepository('AresCoreBundle:Task')->findAll();

        return $this->render('AresCoreBundle:Historical:tasks.html.twig', array(
                    'tasks' => $tasks,
                    'taskId' => $id
        ));
    } else {
        $Task = $em->getRepository('AresCoreBundle:Task')->find($id);
        $jsonGantt = array("data" => array(), "links" => array());
        
        $i = $j = $k = 1;
        $datecreated = $Task->getDatecreated();
        $deadline = $Task->getDeadline();
        $jsonGantt['data'][] = array(
            "id" => 1,
            "text" => $Task->getName(),
            "start_date" => $datecreated->format('Y-m-d H:i'),
            "duration" => $datecreated->diff($deadline)->format('%a'),
            "progress" => "1",
            "open" => "true"
        );
        
        foreach ($Task->getUsertasks() as $Usertask) {
            $i = $j;
            $i++;
            $dateInvoke = (!empty($Usertask->getDateinvoke())) ? $Usertask->getDateinvoke() : $datecreated;
            $dateRevoke = (!empty($Usertask->getDaterevoke())) ? $Usertask->getDaterevoke() : $deadline;
            $jsonGantt['data'][] = array(
                "id" => $i,
                "text" => $Task->getName(),
                "start_date" => $dateInvoke->format('Y-m-d H:i'),
                "duration" => $dateInvoke->diff($dateRevoke)->format('%a'),
                "progress" => "1",
                "open" => "true",
                "parent" => 1
            );
            
            $j = $i;
            foreach ($UserTask->getChronometers() as $Chrono) {
                $j++;
                $startdate = $Chrono->getStartdate();
                $stopdate = $Chrono->getStopdate();
                $jsonGantt['data'][] = array(
                    "id" => $j,
                    "text" => $Task->getName() . $j,
                    "start_date" => $startdate->format('Y-m-d H:i'),
                    "duration" => $startdate->diff($stopdate)->format('%a'),
                    "progress" => "1",
                    "open" => "true",
                    "parent" => $i
                );
                $k++;
                $jsonGantt['links'][] = array(
                    "id" => $k,
                    "source" => $i,
                    "target" => $j,
                    "type" => "1"
                );
            }
        }
        
        // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
        $response = new Response(json_encode($jsonGantt));
        
        // Ici, nous définissons le Content-type pour dire au navigateur
        // que l'on renvoie du JSON et non du HTML
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
  }
    /**
     * @Route("/task/{id}", name="admin_task_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('AresCoreBundle:Task')->findOneById($id);

        $chronometers = $em->getRepository('AresCoreBundle:Chronometer')->getChronometersByTaskId($id);

        $chronometersTotal = 0;
        foreach ($chronometers as $chronometer) {
            $chronometersTotal += $chronometer['time'];
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AresCoreBundle:Task:show.html.twig', array(
            'chronometersTotal' => $chronometersTotal,
            'chronometers' => $chronometers,
            'task' => $task,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/week", name="admin_week_show")
     */
    public function weekAction()
    {
        $em = $this->getDoctrine()->getManager();

        $times = $em->getRepository('AresCoreBundle:Chronometer')->getCurrentWeek();

        return $this->render('AresCoreBundle:Week:index.html.twig', array(
            'times' => $times

        ));
    }
}
