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

    public function fetch_all($rows) {
        return $this->dataBase->fetch_all($rows);
    }

    public final function getApiEventList()
    {
        $query = "SELECT `Altura`, `Calle`, `DescripcionCalendario`, `DescripcionEvento`, `Destacado`, `DetalleTexto`, `DireccionEvento`, `FechaHoraFin`, `FechaHoraInicio`, `Frecuencia`, `IdArea`, `IdCalendario`, `IdEvento`, `IdSubarea`, `Latitud`, `Longitud`, `Lugar`, `NombreArea`, `NombreCalendario`, `NombreEvento`, `NombreSubAreaFormat`, `NombreSubarea`, `Precio`, `Repetir`, `RutaImagen`, `RutaImagenMiniatura`, `TodoDia`, `ZonaHoraria` FROM `EVENT_API` limit 28";
        return $this->dataBase->query($query);
    }

    public final function getEvents($user, $from, $to)
    {
        $dateConstraint="";
        if ($from && $to) {
            $dateConstraint =  " WHERE
                                EVENTS.FechaHoraInicio >= '$from'
                                AND
                                EVENTS.FechaHoraFin <= '$to'";
        } elseif ($from) {
            $dateConstraint =  " WHERE
                                EVENTS.FechaHoraInicio >= '$from'";
        } elseif ($to) {
            $dateConstraint =  " WHERE
                                EVENTS.FechaHoraFin <= '$to'";
        }
        $andUser = $user ? "AND idUser = '$user'" : "";
        $query = "
            SELECT *
            FROM (
                SELECT
                    null AS Id,
                    EA.Altura,
                    EA.Calle,
                    EA.DescripcionCalendario,
                    EA.DescripcionEvento,
                    EA.Destacado,
                    EA.DetalleTexto,
                    EA.DireccionEvento,
                    EA.FechaHoraFin,
                    EA.FechaHoraInicio,
                    EA.Frecuencia,
                    EA.IdArea,
                    EA.IdCalendario,
                    EA.IdEvento,
                    EA.IdSubarea,
                    EA.Latitud,
                    EA.Longitud,
                    EA.Lugar,
                    EA.NombreArea,
                    EA.NombreCalendario,
                    EA.NombreEvento,
                    EA.NombreSubAreaFormat,
                    EA.NombreSubArea,
                    EA.Precio,
                    EA.Repetir,
                    EA.RutaImagen,
                    EA.RutaImagenMiniatura,
                    EA.TodoDia,
                    EA.ZonaHoraria,
                    CS.stars,
                    CASE WHEN FEU.idEvento IS NOT NULL AND FEU.idUser IS NOT NULL THEN 1 ELSE 0 END AS favorite
                FROM EVENT_API EA
                LEFT JOIN
                    (SELECT * FROM FAVORITE_EVENT_USER FE WHERE FE.eventFromApi = 1 ".$andUser.") as FEU ON EA.idEvento = FEU.idEvento
                LEFT JOIN
                    (SELECT FLOOR(AVG (C.stars))  AS stars, C.idEvent
                        FROM COMMENT C
                        /*LEFT JOIN COMMENT_STATUS S ON C.idCommentStatus = S.id
                        WHERE C.eventFromApi = 1 AND S.description LIKE 'Aprobado'*/
                        WHERE C.idCommentStatus = 1
                        GROUP BY idEvent) as CS ON EA.idEvento = CS.idEvent
            UNION  ALL
                SELECT
                    E.Id,
                    E.Altura,
                    E.Calle,
                    E.DescripcionCalendario,
                    E.DescripcionEvento,
                    E.Destacado,
                    E.DetalleTexto,
                    E.DireccionEvento,
                    E.FechaHoraFin,
                    E.FechaHoraInicio,
                    E.Frecuencia,
                    E.IdArea,
                    E.IdCalendario,
                    E.IdEvento,
                    E.IdSubarea,
                    E.Latitud,
                    E.Longitud,
                    E.Lugar,
                    E.NombreArea,
                    E.NombreCalendario,
                    E.NombreEvento,
                    E.NombreSubAreaFormat,
                    E.NombreSubArea,
                    E.Precio,
                    E.Repetir,
                    E.RutaImagen,
                    E.RutaImagenMiniatura,
                    E.TodoDia,
                    E.ZonaHoraria,
                    CS.stars,
                    CASE WHEN FEU.idEvento IS NOT NULL AND FEU.idUser IS NOT NULL THEN 1 ELSE 0 END AS favorite
                FROM   EVENT  E
                LEFT JOIN
                    (SELECT * FROM FAVORITE_EVENT_USER FE WHERE FE.eventFromApi = 2 ".$andUser.") as FEU ON E.id = FEU.idEvento
                LEFT JOIN
                    (SELECT AVG (C.stars) AS stars, C.idEvent
                        FROM COMMENT C
                        /*LEFT JOIN COMMENT_STATUS S ON C.idCommentStatus = S.id
                        WHERE C.eventFromApi = 0 AND S.description LIKE 'Aprobado'*/
                        WHERE C.idCommentStatus = 1
                        GROUP BY idEvent) as CS ON E.id = CS.idEvent
            WHERE E.Active = 1) EVENTS ".$dateConstraint." ORDER BY EVENTS.FechaHoraInicio";

        return $this->dataBase->query($query);
    }

    public final function getMyEvents($user)
    {
        $query = "
                SELECT
                    E.Id,
                    E.IdUser,
                    E.Active,
                    E.DescripcionEvento,
                    E.DetalleTexto,
                    E.DireccionEvento,
                    E.FechaHoraFin,
                    E.FechaHoraInicio,
                    E.IdArea,
                    E.IdCalendario,
                    E.IdEvento,
                    E.IdSubarea,
                    E.Lugar,
                    E.NombreEvento,
                    E.Precio,
                    E.RutaImagen,
                    E.ZonaHoraria,
                    CS.stars,
                    CASE WHEN FEU.idEvento IS NOT NULL AND FEU.idUser IS NOT NULL THEN 1 ELSE 0 END AS favorite
                FROM   EVENT  E
                LEFT JOIN
                    (SELECT * FROM FAVORITE_EVENT_USER FE WHERE FE.eventFromApi = 2 AND idUser = '$user') as FEU ON E.id = FEU.idEvento
                LEFT JOIN
                    (SELECT AVG (C.stars) AS stars, C.idEvent
                        FROM COMMENT C
                        LEFT JOIN COMMENT_STATUS S ON C.idCommentStatus = S.id
                        WHERE C.eventFromApi = 0 AND S.description LIKE 'Aprobado'
                        GROUP BY idEvent) as CS ON E.id = CS.idEvent
            WHERE E.Active = 1 AND E.idUser = '$user' ORDER BY E.FechaHoraInicio";

        return $this->dataBase->query($query);
    }

    public final function addEvent(
        $userId
        , $eventStatus
        , $descripcionEvento
        , $detalleTexto
        , $direccionEvento
        , $fechaHoraFin
        , $fechaHoraInicio
        //, $idArea
        , $idCalendario
        , $idSubarea
        , $lugar
        , $nombreEvento
        , $precio
        , $rutaImagen
        , $zonaHoraria
    ) {
        $query = "
            insert into EVENT(
              IdUser
              , Active
              , DescripcionEvento
              , DetalleTexto
              , DireccionEvento
              , FechaHoraFin
              , FechaHoraInicio
              , IdArea
              , IdCalendario
              , IdEvento
              , IdSubarea
              , Lugar
              , NombreEvento
              , Precio
              , RutaImagen
              , ZonaHoraria
            )
            values (
              '$userId'
              , '$eventStatus'
              , '$descripcionEvento'
              , '$detalleTexto'
              , '$direccionEvento'
              , '$fechaHoraFin'
              , '$fechaHoraInicio'
              , '2'
              , '$idCalendario'
              , null
              , '$idSubarea'
              , '$lugar'
              , '$nombreEvento'
              , '$precio'
              , '$rutaImagen'
              , '$zonaHoraria'
            )";
        return $this->dataBase->query($query);
    }

    public function addFavorite($user, $event, $fromAPI) {
        $query = "
            INSERT INTO FAVORITE_EVENT_USER (idUser, idEvento, eventFromApi)
            VALUES ('$user', $event, $fromAPI)";
        return $this->dataBase->query($query);
    }

    public function removeFavorite($user, $event) {
        $query = "
            DELETE FROM FAVORITE_EVENT_USER
            WHERE idUser = '$user'
            AND idEvento = $event";
        return $this->dataBase->query($query);
    }

    public function getEventById($id)
    {
        return $this->dataBase->query("select * from `EVENT` WHERE Id = $id");
    }

    public function getEvent($idUser, $idEvento)
    {
        $query = "
            SELECT * FROM EVENT
            WHERE Id = $idEvento
            AND IdUser = $idUser
        ";
        return $this->dataBase->query($query);
    }

    public function updateEvent(
        $idEvent
        ,  $descripcionEvento
        , $detalleTexto
        , $direccionEvento
        , $fechaHoraFin
        , $fechaHoraInicio
        , $lugar
        , $nombreEvento
        , $precio
        , $rutaImagen
        , $zonaHoraria
    )
    {
        $query = "
          UPDATE EVENT SET
              DescripcionEvento = '$descripcionEvento',
              DetalleTexto = '$detalleTexto',
              DireccionEvento = '$direccionEvento',
              FechaHoraFin ='$fechaHoraFin',
              FechaHoraInicio = '$fechaHoraInicio',
              Lugar = '$lugar',
              NombreEvento = '$nombreEvento',
              Precio = $precio,
              RutaImagen = '$rutaImagen',
              ZonaHoraria = '$zonaHoraria'
          WHERE Id = $idEvent";
        return $this->dataBase->query($query);
    }

    public function deleteEvent($id)
    {
        return $this->dataBase->query("update EVENT set Active = '0' where Id = $id");
    }

}