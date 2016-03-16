<?php
/**
 * Created by PhpStorm.
 * User: Toshiba
 * Date: 16-03-2016
 * Time: 18:04
 */

namespace Wanasni\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        $builder->add('firstname','text',array(
            'attr'=>array('class'=>'form-control')
        ))
        ->add('lastname','text',array(
            'attr'=>array('class'=>'form-control')
        ))
        ->add('phone','text',array(
            'attr'=>array('class'=>'form-control','placeholder'=>'XX XXX XXX')
        ))
        ->add('date_naissance','text',array(
            'attr'=> array('datepicker'=>'','class'=>'form-control','placeholder'=>'JJ/MM/AAAA')
        ))

        ->add('minibio','textarea',array(
            'attr'=>array('class'=>'form-control')
        ))


        ;
    }

    public function getName()
    {
        return 'wanasni_user_edit_profile';
    }
}