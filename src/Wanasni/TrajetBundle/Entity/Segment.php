<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Wanasni\TrajetBundle\Entity\Trajet;

/**
 * Segment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wanasni\TrajetBundle\Entity\SegmentRepository")
 */
class Segment
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
     * @ORM\Column(name="Distance", type="string", length=10)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="Duration", type="string", length=20)
     */
    private $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="Prix", type="integer")
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="Order", type="integer")
     */
    private $order;


    /**
     * @var Point
     * @ORM\OneToOne(targetEntity="Point")
     * @ORM\JoinColumn(name="start_id", nullable=false)
     */
    private $start;

    /**
     * @var Point
     * @ORM\OneToOne(targetEntity="Point")
     * @ORM\JoinColumn(name="end_id", nullable=false)
     */
    private $end;

    /**
     * @ORM\ManyToOne(targetEntity="Trajet", inversedBy="Segments")
     */
    private $trajet;

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
     * Set distance
     *
     * @param string $distance
     * @return Segment
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    
        return $this;
    }

    /**
     * Get distance
     *
     * @return string 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set duration
     *
     * @param string $duration
     * @return Segment
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return string 
     */
    public function getDuration()
    {
        return $this->duration;
    }





    /**
     * Set order
     *
     * @param integer $order
     * @return Segment
     */
    public function setOrder($order)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set start
     *
     * @param \Wanasni\TrajetBundle\Entity\Point $start
     * @return Segment
     */
    public function setStart(\Wanasni\TrajetBundle\Entity\Point $start)
    {
        $this->start = $start;
    
        return $this;
    }

    /**
     * Get start
     *
     * @return \Wanasni\TrajetBundle\Entity\Point 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \Wanasni\TrajetBundle\Entity\Point $end
     * @return Segment
     */
    public function setEnd(\Wanasni\TrajetBundle\Entity\Point $end)
    {
        $this->end = $end;
    
        return $this;
    }

    /**
     * Get end
     *
     * @return \Wanasni\TrajetBundle\Entity\Point 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set trajet
     *
     * @param \Wanasni\TrajetBundle\Entity\Trajet $trajet
     * @return Segment
     */
    public function setTrajet(\Wanasni\TrajetBundle\Entity\Trajet $trajet = null)
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

    /**
     * Set prix
     *
     * @param integer $prix
     * @return Segment
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    
        return $this;
    }

    /**
     * Get prix
     *
     * @return integer 
     */
    public function getPrix()
    {
        return $this->prix;
    }
}