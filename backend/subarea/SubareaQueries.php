<?php
/**
 * Created by PhpStorm.
 * User: PADomine
 * Date: 10/5/14
 * Time: 16:17
 */

include_once('../database/DataBase.php');

class SubareaQueries {

    private $dataBase;

    function __construct()
    {
        $this->dataBase = new DataBase();
    }

}