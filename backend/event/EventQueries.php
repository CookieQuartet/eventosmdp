<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

include_once('../database/DataBase.php');


class EventQueries {

    private $dataBase;

    function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public final function getEventList() //Lista de Usuarios
    {
        return $this->dataBase->query("select * from event");
    }

    public final function addEvent($event)
    {
        return $this->dataBase->query("insert into event (id_api, id_area, id_subarea, name, description, description_short, address_place, price, frecuency, date_start, date_end, repeat, all_day, image_url, image_url_small, active) values ('$event->getApiId() )");
    }

    public final function getUserById($id)
    {
        return $this->dataBase->query("select * from `event` WHERE id = $id");
    }

}