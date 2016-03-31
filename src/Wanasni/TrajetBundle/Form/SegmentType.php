<?php

namespace Wanasni\TrajetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SegmentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('distance','text',array(
                'attr'=>array('class'=>'distance form-control'),
                'data'=>'0 km',
                'read_only'=>true,
                'label'=>false

            ))
            ->add('duration','text',array(
                'attr'=>array('class'=>'duration form-control'),
                'data'=>'0 heure 0 min',
                'read_only'=>true,
                'label'=>false
            ))

            ->add('prix','number',array(
                'attr'=>array('class'=>'prix form-control'),
                'label'=>false,
                'data'=>0,
            ))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wanasni\TrajetBundle\Entity\Segment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wanasni_trajetbundle_segment';
    }
}
