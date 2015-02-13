<?php

namespace Ares\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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

    $tasks = $em->getRepository('AresCoreBundle:Task')->findAll();

    return $this->render('AresCoreBundle:Admin:index.html.twig', array(
                'tasks' => $tasks
    ));
  }

  /**
   *  @Route("/task/new", name="admin_task_new")
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
   *  @Route("/task/create", name="admin_task_create")
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



//        // On récupere les usertasks déja enregistrées
//        $previousCollections = $entityTask->getUsertasks();
//        $previousCollections = $previousCollections->toArray();
//
//        if(!empty($previousCollections)){
//
//            foreach($previousCollections as $pc){
////                \Doctrine\Common\Util\Debug::dump($pc->getUser());
//                
//                $previousUsersArray[] = $pc->getUser()->getId();
//                        
//            }
//
//            $requestArray = $request->request->all();
//            
//            $requestArrayClone = $requestArray['ares_corebundle_task']['users'];
//            $requestArray['ares_corebundle_task']['users'] = array();
//
//            
//            
//            
//            // Enleve les users deja enregistrés qui ne sont pas dans la requete
//            foreach($previousCollections as $pc){
//                if(!in_array($pc->getUser()->getId(),$requestArrayClone)){
//                    
//                    
//                    $entityTask->removeUsertask($pc);
//                    
//                    
//                    
//                    
//                    
//                    
//                }
//            }
//
//            // Enleve les users de la requete qui sont deja enregistrés
//            foreach($requestArrayClone as $ru){
//                if(!in_array($ru,$previousUsersArray)){
//                    $requestArray['ares_corebundle_task']['users'][] = (int) $ru;
//                }
//            }
//
//            // Remplace la requete
//            $request->request->replace($requestArray);
//
//        }






    $editForm->handleRequest($request);


    if ($editForm->isValid()) {
      

      $postArray = $request->request->get('ares_corebundle_task');
      $selectedUsers = $postArray['users'];

//      dump($selectedUsers);
      
//      dump($entityTask);
      $usertasks = $entityTask->getUsertasks();
      foreach ($usertasks as $usertask) {
        
        
        if ($usertask->getId() !== null) {
//          dump($usertask);
          $user = $usertask->getUser();
          if (in_array($user->getId(), $selectedUsers)) {
            $usertask->setAssignation(true);
          } else {
            $usertask->setAssignation(false);
          }
          
        }
      }
      
//      die;

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
                    ->getForm()
    ;
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
        $users = $em->getRepository('AresCoreBundle:User')->findAll();

        return $this->render('AresCoreBundle:Historical:users.html.twig', array(
                    'users' => $users,
                    'userId' => $id
        ));
    } else {
        $user = $em->getRepository('AresCoreBundle:User')->find($id);
        // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
        $response = new Response('{
            data:[
                {id:1, text:"Project #1",start_date:"01-04-2013", duration:11,
                progress: 0.6, open: true},
                {id:2, text:"Task #1",   start_date:"03-04-2013", duration:5, 
                progress: 1,   open: true, parent:1},
                {id:3, text:"Task #2",   start_date:"02-04-2013", duration:7, 
                progress: 0.5, open: true, parent:1},
                {id:4, text:"Task #2.1", start_date:"03-04-2013", duration:2, 
                progress: 1,   open: true, parent:3},
                {id:5, text:"Task #2.2", start_date:"04-04-2013", duration:3, 
                progress: 0.8, open: true, parent:3},
                {id:6, text:"Task #2.3", start_date:"05-04-2013", duration:4, 
                progress: 0.2, open: true, parent:3}
            ],
            links:[
                {id:1, source:1, target:2, type:"1"},
                {id:2, source:1, target:3, type:"1"},
                {id:3, source:3, target:4, type:"1"},
                {id:4, source:4, target:5, type:"0"},
                {id:5, source:5, target:6, type:"0"}
            ]
        }');

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

    $tasks = $em->getRepository('AresCoreBundle:Task')->findAll();

    return $this->render('AresCoreBundle:Historical:tasks.html.twig', array(
                'tasks' => $tasks
    ));
  }
  
  /**
   * @Route("/task/{id}", name="admin_task_show")
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $task = $em->getRepository('AresCoreBundle:Task')->findOneById($id);

    $chronometers = $em->getRepository('AresCoreBundle:Chronometer')->getChronometersByTaskId($id);

    $chronometersTotal =0;
    foreach($chronometers as $chronometer){
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
