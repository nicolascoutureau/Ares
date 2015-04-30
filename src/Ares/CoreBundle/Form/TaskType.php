<?php
namespace Ares\CoreBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array('label' => 'Nom'))
            ->add('description','textarea')
            ->add('deadline', 'datetime', array(
                'widget' => 'single_text',
                'empty_value' => '-',
                'required' => true,
                'format' => 'dd-MM-yyyy HH:mm',
                'attr'=> [
                    'class' => 'datetimepicker'
                ],
                'label' => 'Échéance'
            ))
            ->add('estimated_time', null, array(
                'required' => true,
                'attr' => ['class' => 'hide'],
                'label' => ' '
                ))
            ->add('estimated_time_to_convert','time', array('mapped' => false, 'label' => 'Temps estimé'))    
            ->add('state', 'choice', array(
                'choices'   => array(
                    'Not Assigned'   => '-- Forcer un état --',
//                    'In Progress' => 'In Progress',
                    'Completed'   => 'Tâche terminée',
                    'Canceled' => 'Tâche annulée',
//                    'Not Assigned' => 'Not Assigned'
                ),
                'multiple'  => false,
                'label' => 'État',
//                'empty_value' => '-- Forcer un état --',
            ))
            ->add('users', 'entity', array(
                'attr' => array(
                    'class' => 'select2'
                ),
                'class'    => 'AresUserBundle:User',
                'required' => false,
                'property' => 'username',
                'expanded' => false,
                'multiple' => true,
                'label' => 'Utilisateurs'
                ))               
//            ->add('timespent', 'text')               
        ;
        

        
        
        
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ares\CoreBundle\Entity\Task'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'ares_corebundle_task';
    }
}