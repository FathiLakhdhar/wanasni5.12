<?php
namespace Wanasni\TrajetBundle\Entity;


class Search
{

    /**
     * @var string
     */
    private $origine;
    /**
     * @var string
     */
    private $destination;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * Search constructor.
     */
    public function __construct()
    {
        $this->date=date('Y-m-d');
    }


    /**
     * @return DateTime
     */
    public function getDate()
    {
        return date_format($this->date,'Y-m-d');
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = date_create($date);
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return string
     */
    public function getOrigine()
    {
        return $this->origine;
    }

    /**
     * @param string $origine
     */
    public function setOrigine($origine)
    {
        $this->origine = $origine;
    }


}