<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Wanasni\TrajetBundle\Entity\TrajetDate;
use Wanasni\TrajetBundle\Entity\Preferences;
use Symfony\Component\Validator\Constraints as Assert;
use Wanasni\TrajetBundle\Entity\Point;
use Wanasni\VehiculeBundle\Entity\Vehicule;

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
     * @var Point
     * @ORM\OneToOne(targetEntity="Point", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="origine_id", nullable=false)
     */
    private $Origine;

    /**
     * @var Point
     *@ORM\OneToOne(targetEntity="Point", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="destination_id", nullable=false)
     */
    private $Destination;

    /**
     * @ORM\OneToMany(targetEntity="Point", mappedBy="trajet")
     */
    private $waypoints;


    /**
     * @var string
     *
     * @ORM\Column(name="frequence", type="string", length=10)
     * @Assert\Choice(choices = {"unique", "regulier"}, message = "Choose a valid frequence.")
     */
    private $frequence;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlaces", type="integer")
     *  @Assert\NotBlank()
     */
    private $nbPlaces;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlacesRestants", type="integer")
     */
    private $nbPlacesRestants;


    /**
     * @ORM\Column(type="string")
     */
    private $totalDuration;

    /**
     * @ORM\Column(type="string")
     */
    private $totalDistance;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $totalPrix;



    /**
     *
     * @ORM\Column(name="Informations_complementaires", type="text", length=500, nullable=true)
     *
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "Your informationsComplementaires cannot be longer than {{ limit }} characters"
     * )
     */
    private $informationsComplementaires;

    /**
     * @var string
     *
     * @ORM\Column(name="heureAller", type="string", length=5, nullable=false)
     *  @Assert\NotBlank()
     */
    private $heureAller;

    /**
     * @var string
     *
     * @ORM\Column(name="heureRetour", type="string", length=5, nullable=true)
     */
    private $heureRetour;

    /**
     * @var integer
     *
     * @ORM\Column(name="Depart_prevu", type="integer", nullable=false)
     *  @Assert\Choice(choices = {0, 10, 20, 30}, message = "Choose a valid Depart prévu")
     */
    private $Depart_prevu;



    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(choices = {"Petit", "Moyen", "Grand", "Aucun"}, message = "Choose a valid Bagages.")
     */
    private $Bagages;


    /**
     *@ORM\OneToOne(targetEntity="Preferences", cascade={"persist","remove"})
     */
    private $Preferences;


    /**
     * @var \DateTime
     */
    private $Date_Allet_unique;

    /**
     * @var \DateTime
     */
    private $Date_Retour_unique;

    /**
     * @var boolean
     */
    private $roundTrip;


    /**
     * @ORM\Column(type="array")
     * @var array
     */
    private $datesAller;

    /**
     * @ORM\Column(type="array")
     * @var array
     */
    private $datesRetour;

    /**
     * @ORM\OneToMany(targetEntity="Wanasni\TrajetBundle\Entity\Segment", mappedBy="trajet")
     */
    private $Segments;

    /**
     * @var \DateTime
     */
    private $regularBeginDate;


    /**
     * @var \DateTime
     */
    private $regularEndDate;


    /**
     * @var Vehicule
     * @ORM\ManyToOne(targetEntity="Wanasni\VehiculeBundle\Entity\Vehicule", inversedBy="trajets")
     */
    private $vehicule;


    /**
     * @var boolean
     *@Assert\IsTrue(message = "Vous devez certifier être en possession d'un permis de conduire et d'une assurance en cours de validité pour publier votre annonce")
     */
    private $cgu;

    /**
     * @return boolean
     */
    public function isCgu()
    {
        return $this->cgu;
    }

    /**
     * @param boolean $cgu
     */
    public function setCgu($cgu)
    {
        $this->cgu = $cgu;
    }


    /**
     * @return \DateTime
     */
    public function getRegularBeginDate()
    {
        return $this->regularBeginDate;
    }

    /**
     * @param \DateTime $regularBeginDate
     */
    public function setRegularBeginDate($regularBeginDate)
    {
        $this->regularBeginDate = $regularBeginDate;
    }


    /**
     * @return \DateTime
     */
    public function getRegularEndDate()
    {
        return $this->regularEndDate;
    }

    /**
     * @param \DateTime $regularEndDate
     */
    public function setRegularEndDate($regularEndDate)
    {
        $this->regularEndDate = $regularEndDate;
    }


    /**
     * Trajet constructor.
     */
    public function __construct()
    {
        $this->datesAller = new ArrayCollection();
        $this->datesRetour = new ArrayCollection();
        $this->waypoints=new ArrayCollection();
        $this->Segments=new ArrayCollection();
    }



    /**
     * @return boolean
     */
    public function isRoundTrip()
    {
        return $this->roundTrip;
    }

    /**
     * @param boolean $roundTrip
     */
    public function setRoundTrip($roundTrip)
    {
        $this->roundTrip = $roundTrip;
    }

    /**
     * @return \DateTime
     */
    public function getDateAlletUnique()
    {
        return $this->Date_Allet_unique;
    }

    /**
     * @param \DateTime $Date_Allet_unique
     */
    public function setDateAlletUnique($Date_Allet_unique)
    {
        $this->Date_Allet_unique = $Date_Allet_unique;
    }

    /**
     * @return \DateTime
     */
    public function getDateRetourUnique()
    {
        return $this->Date_Retour_unique;
    }

    /**
     * @param \DateTime $Date_Retour_unique
     */
    public function setDateRetourUnique($Date_Retour_unique)
    {
        $this->Date_Retour_unique = $Date_Retour_unique;
    }




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
     * Set Bagages
     *
     * @param string $bagages
     * @return Trajet
     */
    public function setBagages($bagages)
    {
        $this->Bagages = $bagages;
    
        return $this;
    }

    /**
     * Get Bagages
     *
     * @return string 
     */
    public function getBagages()
    {
        return $this->Bagages;
    }

    /**
     * Set Preferences
     *
     * @param \Wanasni\TrajetBundle\Entity\Preferences $preferences
     * @return Trajet
     */
    public function setPreferences(\Wanasni\TrajetBundle\Entity\Preferences $preferences = null)
    {
        $this->Preferences = $preferences;
    
        return $this;
    }

    /**
     * Get Preferences
     *
     * @return \Wanasni\TrajetBundle\Entity\Preferences 
     */
    public function getPreferences()
    {
        return $this->Preferences;
    }

    /**
     * Set Origine
     *
     * @param \Wanasni\TrajetBundle\Entity\Point $origine
     * @return Trajet
     */
    public function setOrigine(\Wanasni\TrajetBundle\Entity\Point $origine = null)
    {
        $this->Origine = $origine;
    
        return $this;
    }

    /**
     * Get Origine
     *
     * @return \Wanasni\TrajetBundle\Entity\Point 
     */
    public function getOrigine()
    {
        return $this->Origine;
    }

    /**
     * Set Destination
     *
     * @param \Wanasni\TrajetBundle\Entity\Point $destination
     * @return Trajet
     */
    public function setDestination(\Wanasni\TrajetBundle\Entity\Point $destination = null)
    {
        $this->Destination = $destination;
    
        return $this;
    }

    /**
     * Get Destination
     *
     * @return \Wanasni\TrajetBundle\Entity\Point 
     */
    public function getDestination()
    {
        return $this->Destination;
    }

    /**
     * Add waypoints
     *
     * @param \Wanasni\TrajetBundle\Entity\Point $waypoints
     * @return Trajet
     */
    public function addWaypoint(\Wanasni\TrajetBundle\Entity\Point $waypoints)
    {
        $this->waypoints[] = $waypoints;
    
        return $this;
    }

    /**
     * Remove waypoints
     *
     * @param \Wanasni\TrajetBundle\Entity\Point $waypoints
     */
    public function removeWaypoint(\Wanasni\TrajetBundle\Entity\Point $waypoints)
    {
        $this->waypoints->removeElement($waypoints);
    }

    /**
     * Get waypoints
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWaypoints()
    {
        return $this->waypoints;
    }

    /**
     * Set Depart_prevu
     *
     * @param integer $departPrevu
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
     * @return integer 
     */
    public function getDepartPrevu()
    {
        return $this->Depart_prevu;
    }

    /**
     * Set datesAller
     *
     * @param array $datesAller
     * @return Trajet
     */
    public function setDatesAller($datesAller)
    {
        $this->datesAller = $datesAller;
    
        return $this;
    }

    /**
     * Get datesAller
     *
     * @return array 
     */
    public function getDatesAller()
    {
        return $this->datesAller;
    }

    /**
     * Set datesRetour
     *
     * @param array $datesRetour
     * @return Trajet
     */
    public function setDatesRetour($datesRetour)
    {
        $this->datesRetour = $datesRetour;
    
        return $this;
    }

    /**
     * Get datesRetour
     *
     * @return array 
     */
    public function getDatesRetour()
    {
        return $this->datesRetour;
    }

    /**
     * Set totalDuration
     *
     * @param string $totalDuration
     * @return Trajet
     */
    public function setTotalDuration($totalDuration)
    {
        $this->totalDuration = $totalDuration;
    
        return $this;
    }

    /**
     * Get totalDuration
     *
     * @return string 
     */
    public function getTotalDuration()
    {
        return $this->totalDuration;
    }

    /**
     * Set totalDistance
     *
     * @param string $totalDistance
     * @return Trajet
     */
    public function setTotalDistance($totalDistance)
    {
        $this->totalDistance = $totalDistance;
    
        return $this;
    }

    /**
     * Get totalDistance
     *
     * @return string 
     */
    public function getTotalDistance()
    {
        return $this->totalDistance;
    }

    /**
     * Add Segments
     *
     * @param \Wanasni\TrajetBundle\Entity\Segment $segments
     * @return Trajet
     */
    public function addSegment(\Wanasni\TrajetBundle\Entity\Segment $segments)
    {
        $this->Segments[] = $segments;
    
        return $this;
    }

    /**
     * Remove Segments
     *
     * @param \Wanasni\TrajetBundle\Entity\Segment $segments
     */
    public function removeSegment(\Wanasni\TrajetBundle\Entity\Segment $segments)
    {
        $this->Segments->removeElement($segments);
    }

    /**
     * Get Segments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSegments()
    {
        return $this->Segments;
    }

    /**
     * Set vehicule
     *
     * @param \Wanasni\VehiculeBundle\Entity\Vehicule $vehicule
     * @return Trajet
     */
    public function setVehicule(\Wanasni\VehiculeBundle\Entity\Vehicule $vehicule = null)
    {
        $this->vehicule = $vehicule;
    
        return $this;
    }

    /**
     * Get vehicule
     *
     * @return \Wanasni\VehiculeBundle\Entity\Vehicule 
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }

    /**
     * Set totalPrix
     *
     * @param integer $totalPrix
     * @return Trajet
     */
    public function setTotalPrix($totalPrix)
    {
        $this->totalPrix = $totalPrix;
    
        return $this;
    }

    /**
     * Get totalPrix
     *
     * @return integer 
     */
    public function getTotalPrix()
    {
        return $this->totalPrix;
    }
}