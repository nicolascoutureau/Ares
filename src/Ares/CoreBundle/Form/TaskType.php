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
                'required'  => true,
                'format'    => 'dd-MM-yyyy',
            ))
            ->add('estimated_time','integer')
            ->add('state', 'choice', array(
                'choices'   => array(
                    'assigned'   => 'Assigned',
                    'inprogress' => 'In progress',
                    'completed'   => 'Completed',
                ),
                'multiple'  => false,
            ))
            ->add('users', 'entity', array(
                'class'    => 'AresCoreBundle:User',
                'property' => 'username',
                'multiple' => true))
            ->add('timespent', 'text')
//            ->add('users', 'entity', array(
//                'class'    => 'AresCoreBundle:User',
//                'property' => 'username',
//                'query_builder' => function(\Ares\CoreBundle\Entity\UserRepository $repo) {
//                  return $repo->myFindUsersAssigned();
//                },                
//                'multiple' => true))                
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