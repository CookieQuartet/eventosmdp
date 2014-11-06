<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 06:11 PM
 */

include_once('CommentQueries.php');

class Comment {
    private $id;
    private $idUser;
    private $text;
    private $idCommentStatus;
    private $idEvent;
    private $eventFromApi;
    private $stars;
    private static $commentQueries;


    function __construct($id, $idUser, $text, $idCommentStatus, $idEvent, $eventFromApi, $stars)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->text = $text;
        $this->idCommentStatus = $idCommentStatus;
        $this->idEvent = $idEvent;
        $this->eventFromApi = $eventFromApi;
        $this->stars = $stars;

    }

    public static function getCommentQueries() {

        if (!isset(self::$commentQueries)) {
            self::$commentQueries = new CommentQueries();
        }

        return self::$commentQueries;
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
    public function getEventFromApi()
    {
        return $this->eventFromApi;
    }

    /**
     * @param mixed $eventFromApi
     */
    public function setEventFromApi($eventFromApi)
    {
        $this->eventFromApi = $eventFromApi;
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



} 