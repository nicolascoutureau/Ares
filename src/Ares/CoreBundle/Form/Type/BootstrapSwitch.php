<?php

namespace Ares\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BootstrapSwitch extends AbstractType
{
    public function setDefaultOptions ( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults( [
            'attr'   => [
                'class'             => 'bootstrap-switch',
                'data-on'           => 'success',
                'data-on-label'     => '<i class=\'fa fa-check\'></i>',
                'data-off'          => 'danger',
                'data-off-label'    => '<i class=\'fa fa-times\'></i>',
            ],
            'required' => false,
        ] );
    }

    public function getParent ()
    {
        return 'checkbox';
    }

    public function getName ()
    {
        return 'switcher';
    }
}