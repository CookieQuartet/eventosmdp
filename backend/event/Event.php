<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 06:11 PM
 */

class Event {
    private $id;
    private $idEvent;
    private $name;
    private $description;
    private $descriptionShort;
    private $namePlace;
    private $addressPlace;
    private $price;
    private $frecuency;
    private $dateStart;
    private $dateEnd;
    private $repeat;
    private $allDay;
    private $imageUrl;
    private $imageUrlSmall;
    private $idArea;
    private $idSubarea;
    private $active;

    function __construct($active, $addressPlace, $allDay, $dateEnd, $dateStart, $description, $descriptionShort, $frecuency, $id, $idArea, $idEvent, $idSubarea, $imageUrl, $imageUrlSmall, $name, $namePlace, $price, $repeat)
    {
        $this->active = $active;
        $this->addressPlace = $addressPlace;
        $this->allDay = $allDay;
        $this->dateEnd = $dateEnd;
        $this->dateStart = $dateStart;
        $this->description = $description;
        $this->descriptionShort = $descriptionShort;
        $this->frecuency = $frecuency;
        $this->id = $id;
        $this->idArea = $idArea;
        $this->idEvent = $idEvent;
        $this->idSubarea = $idSubarea;
        $this->imageUrl = $imageUrl;
        $this->imageUrlSmall = $imageUrlSmall;
        $this->name = $name;
        $this->namePlace = $namePlace;
        $this->price = $price;
        $this->repeat = $repeat;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getAddressPlace()
    {
        return $this->addressPlace;
    }

    /**
     * @param mixed $addressPlace
     */
    public function setAddressPlace($addressPlace)
    {
        $this->addressPlace = $addressPlace;
    }

    /**
     * @return mixed
     */
    public function getAllDay()
    {
        return $this->allDay;
    }

    /**
     * @param mixed $allDay
     */
    public function setAllDay($allDay)
    {
        $this->allDay = $allDay;
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param mixed $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param mixed $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescriptionShort()
    {
        return $this->descriptionShort;
    }

    /**
     * @param mixed $descriptionShort
     */
    public function setDescriptionShort($descriptionShort)
    {
        $this->descriptionShort = $descriptionShort;
    }

    /**
     * @return mixed
     */
    public function getFrecuency()
    {
        return $this->frecuency;
    }

    /**
     * @param mixed $frecuency
     */
    public function setFrecuency($frecuency)
    {
        $this->frecuency = $frecuency;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdArea()
    {
        return $this->idArea;
    }

    /**
     * @param mixed $idArea
     */
    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;
    }

    /**
     * @return mixed
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * @param mixed $idEvent
     */
    public function setIdEvent($idEvent)
    {
        $this->idEvent = $idEvent;
    }

    /**
     * @return mixed
     */
    public function getIdSubarea()
    {
        return $this->idSubarea;
    }

    /**
     * @param mixed $idSubarea
     */
    public function setIdSubarea($idSubarea)
    {
        $this->idSubarea = $idSubarea;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getImageUrlSmall()
    {
        return $this->imageUrlSmall;
    }

    /**
     * @param mixed $imageUrlSmall
     */
    public function setImageUrlSmall($imageUrlSmall)
    {
        $this->imageUrlSmall = $imageUrlSmall;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNamePlace()
    {
        return $this->namePlace;
    }

    /**
     * @param mixed $namePlace
     */
    public function setNamePlace($namePlace)
    {
        $this->namePlace = $namePlace;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getRepeat()
    {
        return $this->repeat;
    }

    /**
     * @param mixed $repeat
     */
    public function setRepeat($repeat)
    {
        $this->repeat = $repeat;
    }




} 