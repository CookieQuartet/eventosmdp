<?php
/**
 * Created by PhpStorm.
 * User: PADomine
 * Date: 10/5/14
 * Time: 16:14
 */
include('AreaQueries.php');

class Area {
    private $id;
    private $description;
    //Subarea extiende de Area? Area contiene un ArrayList de Subareas?
    private static $areaQueries;

    function __construct($id, $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    public static function getAreaQueries() {

        if (!isset(self::$areaQueries)) {
            self::$areaQueries = new AreaQueries();
        }

        return self::$areaQueries;
    }
} 