<?php
/**
 * Created by PhpStorm.
 * User: PADomine
 * Date: 10/5/14
 * Time: 16:88
 */
include('SubreaQueries.php');

class Subarea extends Area{

    private $idArea;

    function __construct($id, $idApi, $descriptionSubArea, $idArea)
    {
        parent::__construct($id,$idApi, $descriptionSubArea);
    }

    public static function getSubareaQueries() {

        if (!isset(self::$SubareaQueries)) {
            self::$SubareaQueries = new SubreaQueries();
        }

        return self::$SubareaQueries;
    }
}