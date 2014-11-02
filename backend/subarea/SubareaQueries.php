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

    public final function getSubareaList()
    {
        return $this->dataBase->query("select * from SUBAREA");
    }

    public final function addSubarea($subarea)
    {
        return $this->dataBase->query("insert into SUBAREA (id_area, description, active) values ('$subarea->getIdArea()' , '$subarea->getDescription()', '$subarea->getActive()' )");
    }

    public final function updateSubarea($subarea)
    {
        $query = "update SUBAREA set 'id_area'='$subarea->getIdArea()', 'description'='$subarea->getDescription()', 'active'='$subarea->getActive()', where 'id'='$subarea->getId()'";
        return $this->dataBase->query($query);
    }

    public final function deleteSubarea($id)
    {
        return $this->dataBase->query("update SUBAREA set active = '0' where id = '$id'");
    }

    public final function getSubareaById($id)
    {
        return $this->dataBase->query("select * from `SUBAREA` WHERE id = $id");
    }

}