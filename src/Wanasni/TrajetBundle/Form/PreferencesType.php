<?php

namespace Wanasni\TrajetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreferencesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fumeurs','checkbox',array(
                'attr'=>array('class'=>'iCheck')
            ))
            ->add('animaux','checkbox',array(
                'attr'=>array('class'=>'iCheck')
            ))
            ->add('animauxEnCage','checkbox',array(
                'attr'=>array('class'=>'iCheck')
            ))
            ->add('musique','checkbox',array(
                'attr'=>array('class'=>'iCheck')
            ))
            ->add('detours','checkbox',array(
                'attr'=>array('class'=>'iCheck')
            ))
            ->add('pauseCafe','checkbox',array(
                'attr'=>array('class'=>'iCheck')
            ))
            ->add('nourriture','checkbox',array(
                'attr'=>array('class'=>'iCheck')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wanasni\TrajetBundle\Entity\Preferences'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wanasni_trajetbundle_preferences';
    }
}
