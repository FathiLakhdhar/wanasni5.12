<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Wanasni\TrajetBundle\Entity\Preferences;
use Symfony\Component\Validator\Constraints as Assert;
use Wanasni\TrajetBundle\Entity\Point;
use Wanasni\UserBundle\Entity\User;
use Wanasni\VehiculeBundle\Entity\Vehicule;

/**
 * Trajet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wanasni\TrajetBundle\Entity\TrajetRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\OneToOne(targetEntity="Wanasni\TrajetBundle\Entity\Point", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $Origine;

    /**
     * @var Point
     * @ORM\OneToOne(targetEntity="Wanasni\TrajetBundle\Entity\Point", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $Destination;

    /**
     * @var Collection
     * @Assert\Valid
     */
    private $waypoints;


    /**
     * @var string
     *
     * @ORM\Column(name="frequence", type="string", length=10)
     * @Assert\Choice(choices = {"UNIQUE", "REGULAR"}, message = "Choose a valid frequence.")
     */
    private $frequence;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlaces", type="integer")
     * @Assert\NotBlank(message="Places ne doit pas être vide.")
     * @Assert\Range(
     *      min = 1,
     *      max = 9,
     *      minMessage = "You must be at least {{ limit }} Places tall to enter",
     *      maxMessage = "You cannot be taller than {{ limit }} Places to enter"
     * )
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
     * @Assert\NotBlank(message="total Durée ne doit pas être vide.")
     */
    private $totalDuration;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="total Distance ne doit pas être vide.")
     */
    private $totalDistance;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     *
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
     * @var \DateTime
     * @ORM\Column(name="heureAller", type="time", nullable=false)
     * @Assert\NotBlank(message="heure Aller ne doit pas être vide.")
     * @Assert\Time()
     */
    private $heureAller;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureRetour", type="time", nullable=false)
     * @Assert\Time()
     */
    private $heureRetour;

    /**
     * @var string
     *
     * @ORM\Column(name="Depart_prevu", type="string", nullable=false)
     * @Assert\Choice(choices = {"Heure exacte", "+/- 10 minutes", "+/- 20 minutes", "+/- 30 minutes"}, message = "Choose a valid Depart prévu")
     */
    private $Depart_prevu;


    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(choices = {"Petit", "Moyen", "Grand", "Aucun"}, message = "Choose a valid Bagages.")
     */
    private $Bagages;


    /**
     * @ORM\OneToOne(targetEntity="Wanasni\TrajetBundle\Entity\Preferences", cascade={"persist","remove"})
     */
    private $Preferences;


    /**
     * @var \DateTime
     * @Assert\NotBlank(message="Date Allet unique ne doit pas être vide.")
     */
    private $Date_Allet_unique;

    /**
     * @var \DateTime
     *
     */
    private $Date_Retour_unique;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $roundTrip;


    /**
     * @var WayDate
     *
     * @ORM\OneToMany(targetEntity="Wanasni\TrajetBundle\Entity\WayDate", mappedBy="tarjet_aller", cascade={"persist", "remove"})
     */
    private $datesAller;

    /**
     * @var WayDate
     * @ORM\OneToMany(targetEntity="Wanasni\TrajetBundle\Entity\WayDate", mappedBy="tarjet_retour", cascade={"persist", "remove"})
     */
    private $datesRetour;

    /**
     * @ORM\OneToMany(targetEntity="Wanasni\TrajetBundle\Entity\Segment", mappedBy="trajet" ,cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Segments;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="start Date Regulier ne doit pas être vide.")
     */
    private $regularBeginDate;


    /**
     * @var \DateTime
     * @Assert\NotBlank(message="fin Date Regulier ne doit pas être vide.")
     */
    private $regularEndDate;


    /**
     * @var Vehicule
     * @ORM\ManyToOne(targetEntity="Wanasni\VehiculeBundle\Entity\Vehicule", inversedBy="trajets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicule;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Wanasni\UserBundle\Entity\User",inversedBy="trajets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conducteur;

    /**
     * @var boolean
     * @Assert\IsTrue(message = "Vous devez certifier être en possession d'un permis de conduire et d'une assurance en cours de validité pour publier votre annonce")
     */
    private $cgu;


    /**
     * @ORM\Column(type="datetime")
     */
    private $proposerAt;


    /**
     * @ORM\OneToMany(targetEntity="Wanasni\TrajetBundle\Entity\Reservation", mappedBy="trajet")
     */
    private $reservations;



    /**
     * Trajet constructor.
     */
    public function __construct()
    {

        $this->waypoints = new ArrayCollection();
        $this->Segments = new ArrayCollection();
        $this->datesAller = new ArrayCollection();
        $this->datesRetour = new ArrayCollection();
        $this->reservations=new ArrayCollection();
        $this->nbPlacesRestants = 0;
        $this->Date_Allet_unique = date("Y-m-d");
        $this->Date_Retour_unique = date("Y-m-d");
        $this->regularBeginDate = date("Y-m-d");
        $this->regularEndDate = date("Y-m-d");
    }




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


    /**
     * Set heureRetour
     *
     * @param \DateTime $heureRetour
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
     * @return \DateTime
     */
    public function getHeureRetour()
    {
        return $this->heureRetour;
    }

    /**
     * Set heureAller
     *
     * @param \DateTime $heureAller
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
     * @return \DateTime
     */
    public function getHeureAller()
    {
        return $this->heureAller;
    }

    /**
     * Set conducteur
     *
     * @param \Wanasni\UserBundle\Entity\User $conducteur
     * @return Trajet
     */
    public function setConducteur(\Wanasni\UserBundle\Entity\User $conducteur = null)
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    /**
     * Get conducteur
     *
     * @return \Wanasni\UserBundle\Entity\User
     */
    public function getConducteur()
    {
        return $this->conducteur;
    }


    /**
     * Get roundTrip
     *
     * @return boolean
     */
    public function getRoundTrip()
    {
        return $this->roundTrip;
    }

    /**
     * Add datesAller
     *
     * @param \Wanasni\TrajetBundle\Entity\WayDate $datesAller
     * @return Trajet
     */
    public function addDatesAller(\Wanasni\TrajetBundle\Entity\WayDate $datesAller)
    {
        $this->datesAller[] = $datesAller;

        return $this;
    }

    /**
     * Remove datesAller
     *
     * @param \Wanasni\TrajetBundle\Entity\WayDate $datesAller
     */
    public function removeDatesAller(\Wanasni\TrajetBundle\Entity\WayDate $datesAller)
    {
        $this->datesAller->removeElement($datesAller);
    }

    /**
     * Get datesAller
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDatesAller()
    {
        return $this->datesAller;
    }

    /**
     * Add datesRetour
     *
     * @param \Wanasni\TrajetBundle\Entity\WayDate $datesRetour
     * @return Trajet
     */
    public function addDatesRetour(\Wanasni\TrajetBundle\Entity\WayDate $datesRetour)
    {
        $this->datesRetour[] = $datesRetour;

        return $this;
    }

    /**
     * Remove datesRetour
     *
     * @param \Wanasni\TrajetBundle\Entity\WayDate $datesRetour
     */
    public function removeDatesRetour(\Wanasni\TrajetBundle\Entity\WayDate $datesRetour)
    {
        $this->datesRetour->removeElement($datesRetour);
    }

    /**
     * Get datesRetour
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDatesRetour()
    {
        return $this->datesRetour;
    }


    public function getDatesAllerToArray()
    {
        $arr = array();
        foreach ($this->getDatesAller() as $wayDate) {
            $arr[] = date_format($wayDate->getDate(), 'Ymd');
        }
        return $arr;
    }

    public function getDatesRetourToArray()
    {
        $arr = array();
        foreach ($this->getDatesRetour() as $wayDate) {
            $arr[] = date_format($wayDate->getDate(), 'Ymd');
        }
        return $arr;
    }

    public function getDatesToArray(){

        $arr=array();

        foreach ($this->getDatesAller() as $wayDate) {
            $arr[]=$wayDate->getDate()->format('Y-m-d');
        }
        foreach ($this->getDatesRetour() as $wayDate) {
            $arr[]=$wayDate->getDate()->format('Y-m-d');
        }

        return $arr;

    }


    /**
     * @ORM\PrePersist()
     */

    public function prePersist()
    {




        if ($this->getFrequence() === "UNIQUE") {
            $wayDateA = new WayDate();
            $wayDateA->setDate($this->getDateAlletUnique());
            $wayDateA->setTarjetAller($this);
            $this->addDatesAller($wayDateA);
            if ($this->isRoundTrip()) {
                $wayDateR = new WayDate();
                $wayDateR->setDate($this->getDateRetourUnique());
                $wayDateR->setTarjetRetour($this);
                $this->addDatesRetour($wayDateR);
            }
        }else{
            foreach( $this->getDatesAller() as $waydate){
                $waydate->setTarjetAller($this);
            }
            foreach( $this->getDatesRetour() as $waydate){
                $waydate->setTarjetRetour($this);
            }
        }

        $arrCollection = new ArrayCollection();

        $arrCollection->add($this->getOrigine());

        foreach ($this->getWaypoints() as $waypoint) {
            $arrCollection->add($waypoint);
        }

        $arrCollection->add($this->getDestination());

        $p = 0;

        foreach ($this->getSegments() as $key => $segment) {
            $segment->setTrajet($this);
            $segment->setStart($arrCollection->get($key));
            $segment->setEnd($arrCollection->get($key + 1));
            $p += $segment->getPrix();
        }

        $this->setTotalPrix($p);
        $this->setProposerAt(new \DateTime());

    }


    /**
     * @ORM\PostLoad()
     */
    public function PostLoad()
    {

        if ($this->getSegments()->count() > 1) {
            for ($i = 1; $i < $this->getSegments()->count(); $i++) {
                $this->addWaypoint($this->getSegments()->get($i)->getStart());
            }
        }


    }



    /**
     * Set proposerAt
     *
     * @param \DateTime $proposerAt
     * @return Trajet
     */
    public function setProposerAt($proposerAt)
    {
        $this->proposerAt = $proposerAt;
    
        return $this;
    }

    /**
     * Get proposerAt
     *
     * @return \DateTime 
     */
    public function getProposerAt()
    {
        return $this->proposerAt;
    }

    /**
     * Add reservations
     *
     * @param \Wanasni\TrajetBundle\Entity\Reservation $reservations
     * @return Trajet
     */
    public function addReservation(\Wanasni\TrajetBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;
    
        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \Wanasni\TrajetBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\Wanasni\TrajetBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}