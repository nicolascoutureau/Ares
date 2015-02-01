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
              'notice', 'La tache a bien été ajoutée!'
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
   * @Route("/task/{id}", name="admin_task_show")
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $task = $em->getRepository('AresCoreBundle:Task')
            ->findOneById($id);
    $deleteForm = $this->createDeleteForm($id);
    return $this->render('AresCoreBundle:Task:show.html.twig', array(
                'task' => $task,
                'delete_form' => $deleteForm->createView(),
    ));
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
                'edit_form' => $editForm->createView(),
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
              'notice', 'La tache a bien été modifée!'
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

}
