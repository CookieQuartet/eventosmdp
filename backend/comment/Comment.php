<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 06:11 PM
 */

class Comment {
    private $id;
    private $text;
    private $idCommentStatus;
    private $idEvent;
    private $stars;

    function __construct($id, $idCommentStatus, $idEvent, $stars, $text)
    {
        $this->id = $id;
        $this->idCommentStatus = $idCommentStatus;
        $this->idEvent = $idEvent;
        $this->stars = $stars;
        $this->text = $text;
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
    public function getIdCommentStatus()
    {
        return $this->idCommentStatus;
    }

    /**
     * @param mixed $idCommentStatus
     */
    public function setIdCommentStatus($idCommentStatus)
    {
        $this->idCommentStatus = $idCommentStatus;
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
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * @param mixed $stars
     */
    public function setStars($stars)
    {
        $this->stars = $stars;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


} 