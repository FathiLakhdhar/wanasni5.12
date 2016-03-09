<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="dateAller", type="date")
     */
    private $dateAller;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRetour", type="date")
     */
    private $dateRetour;


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
}
