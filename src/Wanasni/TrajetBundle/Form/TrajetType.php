<?php

namespace Wanasni\TrajetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Date;

class TrajetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Origine', new PointType())

            ->add('Destination', new PointType())

            ->add('waypoints','collection', array(
                'type'=> new PointType(),
                'allow_add'=> true,
                'allow_delete' => true,
            ))

            ->add('frequence','hidden',array(
                'data'=>'UNIQUE'
            ))

            ->add('round_trip','checkbox')

            ->add('date_allet_unique','text',array(
                'attr'=> array('datepicker'=>'date_allet_unique','placeholder'=>'JJ/MM/AAAA')
            ))


            ->add('heureAller', 'time', array(
                'input'  => 'timestamp',
                'widget' => 'choice',
            ))

            ->add('Depart_prevu', 'choice',
                array('choices' => array('0' => 'Heure exacte', '10' => '+/- 10 minutes', '20' => '+/- 20 minutes', '30' => '+/- 30 minutes')
                ))

            ->add('date_retour_unique','text',array(
                'attr'=> array('datepicker'=>'date_retour_unique','placeholder'=>'JJ/MM/AAAA')
            ))

            ->add('heureRetour', 'time', array(
                'input'  => 'timestamp',
                'widget' => 'choice',
            ))


            ->add('datesAller','collection', array(
                'type'=> 'text',
                'allow_add'=> true,
                'allow_delete' => true,
            ))
            ->add('datesRetour','collection', array(
                'type'=> 'text',
                'allow_add'=> true,
                'allow_delete' => true,
            ))


            ->add('regular_begin_date','text',array(
                'attr'=> array('datepicker'=>'','placeholder'=>'JJ/MM/AAAA'),
            ))

            ->add('regular_end_date','text',array(
                'attr'=> array('datepicker'=>'','placeholder'=>'JJ/MM/AAAA')
            ))

            ->add('Bagages','choice',array(
                'choices'=> array(
                    'Petit'=>'Petit bagage',
                    'Moyen'=>'Bagage moyen',
                    'Grand'=>'Grand bagage',
                    'Aucun'=>'Aucun',
                    ),
                'data'=>'Petit',
                'multiple'=>false,
                'expanded'=>true,
            ))

            ->add('Preferences', new PreferencesType())

            ->add('informationsComplementaires','textarea',array(
                'attr'=>array('class'=>'form-control','placeholder' => '0..500 caractères',),

            ))
            /*

                        ->add('nbPlaces', 'number')



                        ->add('dates', 'collection',array(
                            'type'=> new TrajetDateType(),
                            'allow_add'=>true,
                            'allow_delete'=>true,
                        ))
                        ->add('heureRetour')

            */
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wanasni\TrajetBundle\Entity\Trajet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wanasni_trajetbundle_trajet';
    }
}
