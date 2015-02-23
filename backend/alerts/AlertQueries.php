<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:26 PM
 */
include_once('../database/DataBase.php');

class AlertQueries {

    private $dataBase;

    function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public function fetch_all($rows) {
        return $this->dataBase->fetch_all($rows);
    }

    public final function getAlerts($userId)
    {
        $alertQuery = "
          select *
          from
            ALERT A
          where
            A.id_user = $userId";
        return $this->dataBase->query($alertQuery);
    }

    public final function addAlert($userId, $alert)
    {
       // var_dump($alert);
        $alertQuery = "insert into ALERT (id_user, keyword, active) values ($userId , '$alert->keyword', 1)";
        return $this->dataBase->query_with_last_id($alertQuery);
    }

    public final function deleteAlert($alert)
    {
        $alertQuery = "delete from ALERT where id = $alert->id";
        return $this->dataBase->query($alertQuery);
    }

    public final function updateAlert($alert)
    {
        $alertQuery = "update ALERT set active = $alert->active where id = $alert->id";
        return $this->dataBase->query($alertQuery);

    }
}