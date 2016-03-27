<?php

namespace Wanasni\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modele
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wanasni\VehiculeBundle\Entity\ModeleRepository")
 */
class Modele
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="CarModel", type="string", length=255)
     */
    private $carModel;


    /**
     * @var Marque
     * @ORM\ManyToOne(targetEntity="Wanasni\VehiculeBundle\Entity\Marque", inversedBy="modeles")
     */
    private $marque;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set carModel
     *
     * @param string $carModel
     * @return Modele
     */
    public function setCarModel($carModel)
    {
        $this->carModel = $carModel;
    
        return $this;
    }

    /**
     * Get carModel
     *
     * @return string 
     */
    public function getCarModel()
    {
        return $this->carModel;
    }



    /**
     * Set marque
     *
     * @param \Wanasni\VehiculeBundle\Entity\Marque $marque
     * @return Modele
     */
    public function setMarque(\Wanasni\VehiculeBundle\Entity\Marque $marque = null)
    {
        $this->marque = $marque;
    
        return $this;
    }

    /**
     * Get marque
     *
     * @return \Wanasni\VehiculeBundle\Entity\Marque 
     */
    public function getMarque()
    {
        return $this->marque;
    }
}