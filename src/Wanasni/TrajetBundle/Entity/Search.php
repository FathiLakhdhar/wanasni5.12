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
     * @var string
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
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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