<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 06:11 PM
 */

class Alert {
    private $id;
    private $idUser;
    private $idArea;
    private $isSubarea;
    private $keyword;
    private $active;

    function __construct($active, $id, $idArea, $idUser, $isSubarea, $keyword)
    {
        $this->active = $active;
        $this->id = $id;
        $this->idArea = $idArea;
        $this->idUser = $idUser;
        $this->isSubarea = $isSubarea;
        $this->keyword = $keyword;
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
    public function getIsSubarea()
    {
        return $this->isSubarea;
    }

    /**
     * @param mixed $isSubarea
     */
    public function setIsSubarea($isSubarea)
    {
        $this->isSubarea = $isSubarea;
    }

    /**
     * @return mixed
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param mixed $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }



}