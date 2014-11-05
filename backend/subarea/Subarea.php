<?php
/**
 * Created by PhpStorm.
 * User: PADomine
 * Date: 10/5/14
 * Time: 16:14
 */
include('SubareaQueries.php');

class Subarea {
    private $id;
    private $idArea;
    private $description;
    private $active;
    private static $subareaQueries;

    function __construct($idArea, $active, $description, $id)
    {
        $this->idArea = $idArea;
        $this->active = $active;
        $this->description = $description;
        $this->id = $id;
    }

    public static function getSubareaQueries() {

        if (!isset(self::$subareaQueries)) {
            self::$subareaQueries = new AreaQueries();
        }

        return self::$subareaQueries;
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