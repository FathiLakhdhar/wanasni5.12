<?php

namespace Wanasni\TrajetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            /*
                        ->add('frequence')

                        ->add('nbPlaces', 'number')



                        ->add('dates', 'collection',array(
                            'type'=> new TrajetDateType(),
                            'allow_add'=>true,
                            'allow_delete'=>true,
                        ))

                        ->add('heureAller')

                        ->add('heureRetour')

                        ->add('Depart_prevu', 'choice',
                            array('choices' => array('0' => 'Heure exacte', '10' => '+/- 10 minutes', '20' => '+/- 20 minutes', '30' => '+/- 30 minutes')
                            ))

                        ->add('Bagages')

                        ->add('Preferences', new PreferencesType())

                        ->add('informationsComplementaires')
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
