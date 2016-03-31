<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\DBAL\Types\DecimalType;
use Doctrine\ORM\Mapping as ORM;

/**
 * Point
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wanasni\TrajetBundle\Entity\PointRepository")
 */
class Point
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
     * @ORM\Column(type="string")
     */
    private $lieu;


    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", scale=10)
     */
    private $latitude;
    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", scale=10)
     */
    private $longitude;




    /**
     * @ORM\ManyToOne(targetEntity="Trajet", inversedBy="waypoints")
     *
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
     * Set latitude
     *
     * @param string $latitude
     * @return Point
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Point
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set trajet
     *
     * @param \Wanasni\TrajetBundle\Entity\Trajet $trajet
     * @return Point
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
     * Set lieu
     *
     * @param string $lieu
     * @return Point
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    
        return $this;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }


}