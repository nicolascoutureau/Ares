<?php
// src/Ares/CoreBundle/Admin/TaskAdmin.php

namespace Ares\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TaskAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
//        $formMapper
//            ->add('title', 'text', array('label' => 'Post Title'))
//            ->add('author', 'entity', array('class' => 'Acme\DemoBundle\Entity\User'))
//            ->add('body') //if no type is specified, SonataAdminBundle tries to guess it
//        ;
        
        
        
        
        
        $formMapper
            ->add('name','text', array('label' => 'Name'))
            ->add('description','textarea', array('label' => 'Description'))
            ->add('deadline', 'datetime', array(
                'label'     => 'Deadline',
                'required'  => true,
                'format'    => 'dd-MM-yyyy',
            ))
            ->add('estimated_time','integer', array('label' => 'Estimated Time'))
            ->add('state', 'choice', array(
                'choices'   => array(
                    'label'      => 'State',
                    'assigned'   => 'Assigned',
                    'inprogress' => 'In progress',
                    'completed'   => 'Completed',
                ),
                'multiple'  => false,
            ))
            ->add('users', 'entity', array(
                'label'    => 'Users',
                'class'    => 'AresCoreBundle:User',
                'property' => 'username',
                'multiple' => true))               
        ;        
        
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('description')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('deadline')
            ->add('estimated_time')    
            ->add('state')
            ->add('users', 'array', array('associated_property' => 'getUsername'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                )
            ))                
        ;
    }
}