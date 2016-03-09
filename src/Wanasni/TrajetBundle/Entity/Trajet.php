<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trajet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wanasni\TrajetBundle\Entity\TrajetRepository")
 */
class Trajet
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
     * @ORM\Column(name="frequence", type="string", length=10)
     */
    private $frequence;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlaces", type="integer")
     */
    private $nbPlaces;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlacesRestants", type="integer")
     */
    private $nbPlacesRestants;

    /**
     * @var string
     *
     * @ORM\Column(name="Informations_complementaires", type="string", length=500)
     */
    private $informationsComplementaires;

    /**
     * @var string
     *
     * @ORM\Column(name="heureAller", type="string", length=5)
     */
    private $heureAller;

    /**
     * @var string
     *
     * @ORM\Column(name="heureRetour", type="string", length=5)
     */
    private $heureRetour;

    /**
     * @var string
     *
     * @ORM\Column(name="Depart_prevu", type="string", length=20)
     */
    private $Depart_prevu;


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
     * Set frequence
     *
     * @param string $frequence
     * @return Trajet
     */
    public function setFrequence($frequence)
    {
        $this->frequence = $frequence;
    
        return $this;
    }

    /**
     * Get frequence
     *
     * @return string 
     */
    public function getFrequence()
    {
        return $this->frequence;
    }

    /**
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     * @return Trajet
     */
    public function setNbPlaces($nbPlaces)
    {
        $this->nbPlaces = $nbPlaces;
    
        return $this;
    }

    /**
     * Get nbPlaces
     *
     * @return integer 
     */
    public function getNbPlaces()
    {
        return $this->nbPlaces;
    }

    /**
     * Set nbPlacesRestants
     *
     * @param integer $nbPlacesRestants
     * @return Trajet
     */
    public function setNbPlacesRestants($nbPlacesRestants)
    {
        $this->nbPlacesRestants = $nbPlacesRestants;
    
        return $this;
    }

    /**
     * Get nbPlacesRestants
     *
     * @return integer 
     */
    public function getNbPlacesRestants()
    {
        return $this->nbPlacesRestants;
    }

    /**
     * Set informationsComplementaires
     *
     * @param string $informationsComplementaires
     * @return Trajet
     */
    public function setInformationsComplementaires($informationsComplementaires)
    {
        $this->informationsComplementaires = $informationsComplementaires;
    
        return $this;
    }

    /**
     * Get informationsComplementaires
     *
     * @return string 
     */
    public function getInformationsComplementaires()
    {
        return $this->informationsComplementaires;
    }

    /**
     * Set heureAller
     *
     * @param string $heureAller
     * @return Trajet
     */
    public function setHeureAller($heureAller)
    {
        $this->heureAller = $heureAller;
    
        return $this;
    }

    /**
     * Get heureAller
     *
     * @return string 
     */
    public function getHeureAller()
    {
        return $this->heureAller;
    }

    /**
     * Set heureRetour
     *
     * @param string $heureRetour
     * @return Trajet
     */
    public function setHeureRetour($heureRetour)
    {
        $this->heureRetour = $heureRetour;
    
        return $this;
    }

    /**
     * Get heureRetour
     *
     * @return string 
     */
    public function getHeureRetour()
    {
        return $this->heureRetour;
    }



    /**
     * Set Depart_prevu
     *
     * @param string $departPrevu
     * @return Trajet
     */
    public function setDepartPrevu($departPrevu)
    {
        $this->Depart_prevu = $departPrevu;
    
        return $this;
    }

    /**
     * Get Depart_prevu
     *
     * @return string 
     */
    public function getDepartPrevu()
    {
        return $this->Depart_prevu;
    }
}