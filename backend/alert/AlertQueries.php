<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:26 PM
 */

include('../database/DataBase.php');

class AlertQueries {

    private $dataBase;

    function __construct()
    {
        $this->$dataBase = new DataBase();
    }

    public final function getAlertList() //Lista de Alerts
    {
        $alertQuery = "select AL.*, AR.description description_area, SA.description_subarea from ALERT AL, AREA AR, SUBAREA SA where AL.active = 1 AND AL.id_area = AR.id AND AL.id_subarea = SA.id;";
        return $this->$dataBase->query($alertQuery);
    }

    public final function addAlert($alert)
    {
        $alertQuery = "insert into ALERT (id_user, id_area, id_subarea, keyword) values ('$alert->getIdUser()' , '$alert->getIdArea()', '$alert->getIdSubarea()', '$alert->getKeyword()' )";
        return $this->$dataBase->query($alertQuery);
    }

    public final function updateAlert($alert)
    {
        $alertQuery = "update ALERT set id_area='$alert->getIdArea()', id_subarea='$alert->getIdSubarea()', keyword='$alert->getKeyword()' where id='$alert->getId()'";
        return $this->dataBase->query($alertQuery);
    }

    public final function deleteAlert($id)
    {
        $alertQuery = "update ALERT set active = '0' where id = '$id'";
        return $this->dataBase->query($alertQuery);
    }

    public final function getAlertById($id)
    {
        $alertQuery = "select AL.*, AR.description description_area, SA.description description_subarea from ALERT AL, AREA AR, SUBAREA SA where AL.id = '$id' AND AL.active = 1 AND AL.id_area = AR.id AND AL.id_subarea = SA.id;";
        return $this->dataBase->query($alertQuery);
    }

    public final function getAlertByUserId() //Lista de Alerts por id_user
    {
        $alertQuery = "select * from ALERT AL, AREA AR, SUBAREA SA where AL.active = 1 AND AL.id_area = AR.id AND AL.id_subarea = SA.id;";
        return $this->$dataBase->query($alertQuery);
    }
}