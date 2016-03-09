<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Wanasni\TrajetBundle\Entity\Trajet;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * TrajetDate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wanasni\TrajetBundle\Entity\TrajetDateRepository")
 */
class TrajetDate
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateAller", type="date", nullable=false)
     *  @Assert\Date()
     */
    private $dateAller;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRetour", type="date", nullable=true)
     *  @Assert\Date()
     */
    private $dateRetour;


    /**
     * @var Trajet
     *
     * @ORM\ManyToOne(targetEntity="Trajet", inversedBy="dates")
     * @ORM\JoinColumn(name="trajet_id", referencedColumnName="id", nullable=false)
     */
    protected $trajet;




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
     * Set dateAller
     *
     * @param \DateTime $dateAller
     * @return TrajetDate
     */
    public function setDateAller($dateAller)
    {
        $this->dateAller = $dateAller;
    
        return $this;
    }

    /**
     * Get dateAller
     *
     * @return \DateTime 
     */
    public function getDateAller()
    {
        return $this->dateAller;
    }

    /**
     * Set dateRetour
     *
     * @param \DateTime $dateRetour
     * @return TrajetDate
     */
    public function setDateRetour($dateRetour)
    {
        $this->dateRetour = $dateRetour;
    
        return $this;
    }

    /**
     * Get dateRetour
     *
     * @return \DateTime 
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * Set trajet
     *
     * @param \Wanasni\TrajetBundle\Entity\Trajet $trajet
     * @return TrajetDate
     */
    public function setTrajet(\Wanasni\TrajetBundle\Entity\Trajet $trajet)
    {
        $this->trajet = $trajet;
    
        return $this;
    }

    /**
     * Get trajet
     *
     * @return \Wanasni\TrajetBundle\Entity\Trajet 
     */
    public function getTrajet()
    {
        return $this->trajet;
    }
}