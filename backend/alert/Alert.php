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
    private $descriptionArea;
    private $idSubarea;
    private $descriptionSubarea;
    private $keyword;
    private $active;

    function __construct($id, $idUser, $idArea, $descriptionArea, $idSubarea, $descriptionSubarea, $keyword,$active)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->idArea = $idArea;
        $this->descriptionArea = $descriptionArea;
        $this->idSubarea = $idSubarea;
        $this->descriptionSubarea = $descriptionSubarea;
        $this->keyword = $keyword;
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
    public function getDescriptionArea()
    {
        return $this->descriptionArea;
    }

    /**
     * @param mixed $descriptionArea
     */
    public function setDescriptionSubarea($descriptionArea)
    {
        $this->descriptionArea = $descriptionArea;
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
    public function getDescriptionSubarea()
    {
        return $this->descriptionSubarea;
    }

    /**
     * @param mixed $descriptionSubarea
     */
    public function setDescriptionSubarea($descriptionSubarea)
    {
        $this->descriptionSubarea = $descriptionSubarea;
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

}