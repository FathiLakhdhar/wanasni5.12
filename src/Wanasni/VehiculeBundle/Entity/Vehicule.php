<?php

namespace Wanasni\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Wanasni\UserBundle\Entity\User;
use Wanasni\VehiculeBundle\Entity\Marque;
use Wanasni\VehiculeBundle\Entity\Modele;
/**
 * Vehicule
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wanasni\VehiculeBundle\Entity\VehiculeRepository")
 */
class Vehicule
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
     * @ORM\Column(name="Confort", type="string", length=20)
     * @Assert\Choice(choices = {"BASIC", "NORMAL","COMFORT", "LUXE"}, message = "Choose a valid Confort.")
     */
    private $confort;

    /**
     * @var integer
     *
     * @ORM\Column(name="NbrPlaces", type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 9,
     *      minMessage = "You must be at least {{ limit }} Places tall to enter",
     *      maxMessage = "You cannot be taller than {{ limit }} Places to enter"
     * )
     */
    private $nbrPlaces;

    /**
     * @var string
     *
     * @ORM\Column(name="Couleur", type="string", length=20)
     */
    private $couleur;

    /**
     * @var string
     *
     * @ORM\Column(name="Immatriculation", type="string", length=50)
     */
    private $immatriculation;


    /**
     * @var Marque
     *
     * @ORM\OneToOne(targetEntity="Wanasni\VehiculeBundle\Entity\Marque")
     */
    private $marque;

    /**
     * @var Modele
     *
     * @ORM\OneToOne(targetEntity="Wanasni\VehiculeBundle\Entity\Modele")
     */
    private $modele;


    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Wanasni\UserBundle\Entity\User",inversedBy="vehicules")
     */
    private $user;

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
     * Set confort
     *
     * @param string $confort
     * @return Vehicule
     */
    public function setConfort($confort)
    {
        $this->confort = $confort;
    
        return $this;
    }

    /**
     * Get confort
     *
     * @return string 
     */
    public function getConfort()
    {
        return $this->confort;
    }

    /**
     * Set nbrPlaces
     *
     * @param integer $nbrPlaces
     * @return Vehicule
     */
    public function setNbrPlaces($nbrPlaces)
    {
        $this->nbrPlaces = $nbrPlaces;
    
        return $this;
    }

    /**
     * Get nbrPlaces
     *
     * @return integer 
     */
    public function getNbrPlaces()
    {
        return $this->nbrPlaces;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     * @return Vehicule
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    
        return $this;
    }

    /**
     * Get couleur
     *
     * @return string 
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set immatriculation
     *
     * @param string $immatriculation
     * @return Vehicule
     */
    public function setImmatriculation($immatriculation)
    {
        $this->immatriculation = $immatriculation;
    
        return $this;
    }

    /**
     * Get immatriculation
     *
     * @return string 
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * Set marque
     *
     * @param \Wanasni\VehiculeBundle\Entity\Marque $marque
     * @return Vehicule
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

    /**
     * Set modele
     *
     * @param \Wanasni\VehiculeBundle\Entity\Modele $modele
     * @return Vehicule
     */
    public function setModele(\Wanasni\VehiculeBundle\Entity\Modele $modele = null)
    {
        $this->modele = $modele;
    
        return $this;
    }

    /**
     * Get modele
     *
     * @return \Wanasni\VehiculeBundle\Entity\Modele 
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set user
     *
     * @param \Wanasni\UserBundle\Entity\User $user
     * @return Vehicule
     */
    public function setUser(\Wanasni\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Wanasni\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}