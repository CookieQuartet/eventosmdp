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

    public final function getUsersWithAlerts() {
        $alertQuery = "
          select distinct
            A.id_user,
            U.email,
            U.name
          from
            ALERT A, USER U
            where
                A.id_user = U.id
                and A.active = 1
            ORDER BY A.id_user
            ";
        return $this->dataBase->query($alertQuery);
    }

    public final function getEventAlerts($userId, $fechaDesde, $fechaHasta)
    {
        $alertQuery = "
          select
            A.id_user,
            A.keyword,
            U.email,
            U.name,
            EV.NombreEvento,
            EV.DescripcionEvento,
            EV.DetalleTexto,
            EV.id,
            EV.FechaHoraInicio,
            EV.FechaHoraFin
          from
            ALERT A, USER U, (
                select
                    EVENT.Id,
                    EVENT.DescripcionEvento,
                    EVENT.DetalleTexto,
                    EVENT.NombreEvento,
                	EVENT.FechaHoraInicio,
                	EVENT.FechaHoraFin,
                    CONCAT_WS('|', EVENT.DescripcionEvento, EVENT.DetalleTexto, EVENT.NombreEvento) text
                from EVENT
                union all
                SELECT
                    EVENT_API.IdEvento AS Id,
                    EVENT_API.DescripcionEvento,
                    EVENT_API.DetalleTexto,
                    EVENT_API.NombreEvento,
                	EVENT_API.FechaHoraInicio,
                	EVENT_API.FechaHoraFin,
                    CONCAT_WS('|', EVENT_API.DescripcionEvento, EVENT_API.DetalleTexto, EVENT_API.NombreEvento) text
                from EVENT_API
            ) EV
            where
            	EV.text LIKE CONCAT('%', A.keyword, '%')
                and EV.FechaHoraInicio between '$fechaDesde' and '$fechaHasta'
                and A.id_user = U.id
                and A.id_user = $userId
                and A.active = 1
            ORDER BY A.id_user
            ";
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