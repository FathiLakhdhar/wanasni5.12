<?php

namespace Wanasni\TrajetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlertType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('origine','text')
            ->add('destination','text')

            ->add('email','email',array(
                'attr'=>array('class'=>'form-control','placeholder'=>'Email'),

            ))
            ->add('freqeunce','choice',array(
                'choices'=>array('UNIQUE'=>'Trajet Unique', 'REGULAR'=>'Trajet Regulier'),
                'multiple'=>false,
                'expanded'=>true,
                'data'=>'UNIQUE',
                'label'=>false
            ))
            ->add('date', 'text', array(
                'attr'=>array('class'=>'form-control','datepicker'=>'')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wanasni\TrajetBundle\Entity\Alert'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wanasni_trajetbundle_alert';
    }
}
