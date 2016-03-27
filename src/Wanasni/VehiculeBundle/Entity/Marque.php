<?php

namespace Wanasni\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marque
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wanasni\VehiculeBundle\Entity\MarqueRepository")
 */
class Marque
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
     * @ORM\Column(name="CarBrand", type="string", length=255)
     */
    private $carBrand;


    /**
     * @var Modele
     * @ORM\OneToMany(targetEntity="Wanasni\VehiculeBundle\Entity\Modele", mappedBy="marque", cascade={"remove","persist"})
     */
    private $modeles;


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
     * Set carBrand
     *
     * @param string $carBrand
     * @return Marque
     */
    public function setCarBrand($carBrand)
    {
        $this->carBrand = $carBrand;
    
        return $this;
    }

    /**
     * Get carBrand
     *
     * @return string 
     */
    public function getCarBrand()
    {
        return $this->carBrand;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modeles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add modeles
     *
     * @param \Wanasni\VehiculeBundle\Entity\Modele $modeles
     * @return Marque
     */
    public function addModele(\Wanasni\VehiculeBundle\Entity\Modele $modeles)
    {
        $this->modeles[] = $modeles;
    
        return $this;
    }

    /**
     * Remove modeles
     *
     * @param \Wanasni\VehiculeBundle\Entity\Modele $modeles
     */
    public function removeModele(\Wanasni\VehiculeBundle\Entity\Modele $modeles)
    {
        $this->modeles->removeElement($modeles);
    }

    /**
     * Get modeles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModeles()
    {
        return $this->modeles;
    }
}