<?php

namespace Wanasni\VehiculeBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Wanasni\VehiculeBundle\Entity\Marque;
use Wanasni\VehiculeBundle\Entity\ModeleRepository;

class VehiculeType extends AbstractType
{

    private $marque;
    private $em;

    /**
     * VehiculeType constructor.
     */

    public function __construct(EntityManager $em,Marque $m = null)
    {
        $this->marque=$m;
        $this->em= $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque','entity',array(
                'class'=>'WanasniVehiculeBundle:Marque',
                'property'=>'CarBrand',
                'empty_value'=>'Choisissez',
                'multiple'=> false,
                'attr'=>array('class'=>'form-control'),
                'data'=>$this->em->getRepository('WanasniVehiculeBundle:Marque')
                                    ->findOneBy(
                                        array(
                                            'id'=>$this->marque->getId()
                                        )),

            ))

            ->add('modele','entity',array(
                'class'=> 'Wanasni\VehiculeBundle\Entity\Modele',
                'property'=>'carModel',
                'attr'=>array('class'=>'form-control'),
            ))
            ->add('confort','choice',array(
                'choices'=>array('BASIC'=>'Basique', 'NORMAL'=>'Normal', 'COMFORT'=>'Confort', 'LUXE'=>'Luxe'),
                'attr'=>array('class'=>'form-control')
            ))
            ->add('nbrPlaces','number',array(
                'attr'=>array('class'=>'form-control'),
            ))
            ->add('couleur','entity',array(
                'class'=>'Wanasni\VehiculeBundle\Entity\Couleur',
                'property'=>'nom',
                'multiple'=>false,
                'attr'=>array('class'=>'form-control')
            ))
            ->add('immatriculation','text',array(
                'attr'=>array('class'=>'form-control')
            ))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wanasni\VehiculeBundle\Entity\Vehicule'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wanasni_vehiculebundle_vehicule';
    }
}
