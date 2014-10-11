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
    private $idApi;
    private $description;
    private static $subareaQueries;

    function __construct($id, $description, $idApi)
    {
        $this->id = $id;
        $this->description = $description;
        $this->idApi = $idApi;
    }

    public static function getSubareaQueries() {

        if (!isset(self::$subareaQueries)) {
            self::$subareaQueries = new AreaQueries();
        }

        return self::$subareaQueries;
    }
} 