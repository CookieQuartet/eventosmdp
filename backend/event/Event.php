<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 06:11 PM
 */

class Event {
    private $id; //Id
    private $idUser; //IdUser
    private $active; //Active
    private $height; //Altura
    private $street; //Calle
    private $descriptionCalendar; //DescripcionCalendario
    private $descriptionEvent; //DescripcionEvento
    private $star; //Destacado
    private $detailText; //DetalleTexto
    private $eventAddress; //DireccionEvento
    private $dateEnd; //FechaHoraFin
    private $dateStart; //FechaHoraInicio
    private $frecuency; //Frecuencia
    private $idArea; //IdArea
    private $idCalendar; //IdCalendario
    private $idEvent; //IdEvento
    private $idSubarea; //IdSubarea
    private $latitude; //Latitud
    private $length; //Longitud
    private $place; //Lugar
    private $nameArea; //NombreArea
    private $nameCalendar; //NombreCalendario
    private $nameEvent; //NombreEvento
    private $nameSubAreaFormat; //NombreSubAreaFormat
    private $nameSubarea; //NombreSubArea
    private $price; //Precio
    private $repeat; //Repetir
    private $imageUrl; //RutaImagen
    private $imageUrlSmall; //RutaImagenMiniatura
    private $allDay; //TodoDia
    private $timeZone; //ZonaHoraria

    function __construct($active, $allDay, $dateEnd, $dateStart, $descriptionCalendar, $descriptionEvent, $detailText, $eventAddress, $frecuency, $height, $id, $idArea, $idCalendar, $idEvent, $idSubarea, $idUser, $imageUrl, $imageUrlSmall, $latitude, $length, $nameArea, $nameCalendar, $nameEvent, $nameSubAreaFormat, $nameSubarea, $place, $price, $repeat, $star, $street, $timeZone)
    {
        $this->active = $active;
        $this->allDay = $allDay;
        $this->dateEnd = $dateEnd;
        $this->dateStart = $dateStart;
        $this->descriptionCalendar = $descriptionCalendar;
        $this->descriptionEvent = $descriptionEvent;
        $this->detailText = $detailText;
        $this->eventAddress = $eventAddress;
        $this->frecuency = $frecuency;
        $this->height = $height;
        $this->id = $id;
        $this->idArea = $idArea;
        $this->idCalendar = $idCalendar;
        $this->idEvent = $idEvent;
        $this->idSubarea = $idSubarea;
        $this->idUser = $idUser;
        $this->imageUrl = $imageUrl;
        $this->imageUrlSmall = $imageUrlSmall;
        $this->latitude = $latitude;
        $this->length = $length;
        $this->nameArea = $nameArea;
        $this->nameCalendar = $nameCalendar;
        $this->nameEvent = $nameEvent;
        $this->nameSubAreaFormat = $nameSubAreaFormat;
        $this->nameSubarea = $nameSubarea;
        $this->place = $place;
        $this->price = $price;
        $this->repeat = $repeat;
        $this->star = $star;
        $this->street = $street;
        $this->timeZone = $timeZone;
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
    public function getDescriptionCalendar()
    {
        return $this->descriptionCalendar;
    }

    /**
     * @param mixed $descriptionCalendar
     */
    public function setDescriptionCalendar($descriptionCalendar)
    {
        $this->descriptionCalendar = $descriptionCalendar;
    }

    /**
     * @return mixed
     */
    public function getDescriptionEvent()
    {
        return $this->descriptionEvent;
    }

    /**
     * @param mixed $descriptionEvent
     */
    public function setDescriptionEvent($descriptionEvent)
    {
        $this->descriptionEvent = $descriptionEvent;
    }

    /**
     * @return mixed
     */
    public function getDetailText()
    {
        return $this->detailText;
    }

    /**
     * @param mixed $detailText
     */
    public function setDetailText($detailText)
    {
        $this->detailText = $detailText;
    }

    /**
     * @return mixed
     */
    public function getEventAddress()
    {
        return $this->eventAddress;
    }

    /**
     * @param mixed $eventAddress
     */
    public function setEventAddress($eventAddress)
    {
        $this->eventAddress = $eventAddress;
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
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
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
    public function getIdCalendar()
    {
        return $this->idCalendar;
    }

    /**
     * @param mixed $idCalendar
     */
    public function setIdCalendar($idCalendar)
    {
        $this->idCalendar = $idCalendar;
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
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
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
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getNameArea()
    {
        return $this->nameArea;
    }

    /**
     * @param mixed $nameArea
     */
    public function setNameArea($nameArea)
    {
        $this->nameArea = $nameArea;
    }

    /**
     * @return mixed
     */
    public function getNameCalendar()
    {
        return $this->nameCalendar;
    }

    /**
     * @param mixed $nameCalendar
     */
    public function setNameCalendar($nameCalendar)
    {
        $this->nameCalendar = $nameCalendar;
    }

    /**
     * @return mixed
     */
    public function getNameEvent()
    {
        return $this->nameEvent;
    }

    /**
     * @param mixed $nameEvent
     */
    public function setNameEvent($nameEvent)
    {
        $this->nameEvent = $nameEvent;
    }

    /**
     * @return mixed
     */
    public function getNameSubAreaFormat()
    {
        return $this->nameSubAreaFormat;
    }

    /**
     * @param mixed $nameSubAreaFormat
     */
    public function setNameSubAreaFormat($nameSubAreaFormat)
    {
        $this->nameSubAreaFormat = $nameSubAreaFormat;
    }

    /**
     * @return mixed
     */
    public function getNameSubarea()
    {
        return $this->nameSubarea;
    }

    /**
     * @param mixed $nameSubarea
     */
    public function setNameSubarea($nameSubarea)
    {
        $this->nameSubarea = $nameSubarea;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
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

    /**
     * @return mixed
     */
    public function getStar()
    {
        return $this->star;
    }

    /**
     * @param mixed $star
     */
    public function setStar($star)
    {
        $this->star = $star;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * @param mixed $timeZone
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }



} 