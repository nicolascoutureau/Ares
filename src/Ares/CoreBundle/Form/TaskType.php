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
            ->add('name','text')
            ->add('description','textarea')
            ->add('deadline', 'datetime', array(
                'widget' => 'single_text',
                'empty_value' => '-',
                'required' => true,
                'format' => 'dd-MM-yyyy HH:mm',
                'attr'=> [
                    'class' => 'datetimepicker'
                ]
            ))
            ->add('estimated_time','integer')
            ->add('state', 'choice', array(
                'choices'   => array(
                    'Assigned'   => 'Assigned',
                    'In Progress' => 'In Progress',
                    'Completed'   => 'Completed',
                    'Canceled' => 'Canceled',
                    'Not Assigned' => 'Not Assigned'
                ),
                'multiple'  => false,
            ))
            ->add('users', 'entity', array(
                'attr' => array(
                    'class' => 'select2'
                ),
                'class'    => 'AresUserBundle:User',
                'required' => false,
                'property' => 'username',
                'expanded' => false,
                'multiple' => true))               
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
