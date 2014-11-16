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

    /*public final function getOwnEventsList()
    {
        $result=$this->dataBase->query("select * from EVENT");
        $result=$this->dataBase->fetchQueryResultToAssocArray($result);

        return $result;
    }*/

    public final function getApiEventList() //Lista de Usuarios
    {
        $query = "SELECT `Altura`, `Calle`, `DescripcionCalendario`, `DescripcionEvento`, `Destacado`, `DetalleTexto`, `DireccionEvento`, `FechaHoraFin`, `FechaHoraInicio`, `Frecuencia`, `IdArea`, `IdCalendario`, `IdEvento`, `IdSubarea`, `Latitud`, `Longitud`, `Lugar`, `NombreArea`, `NombreCalendario`, `NombreEvento`, `NombreSubAreaFormat`, `NombreSubarea`, `Precio`, `Repetir`, `RutaImagen`, `RutaImagenMiniatura`, `TodoDia`, `ZonaHoraria` FROM `EVENT_API` limit 28";
        return $this->dataBase->query($query);
    }

    public final function getEvents($from, $to)
    {
        $dateConstraint="";
        if ($from && $to)
        {
            $dateConstraint =  " WHERE
                                EVENTS.FechaHoraInicio >= '$from'
                                AND
                                EVENTS.FechaHoraFin <= '$to' ";
        }
        elseif ($from)
        {
            $dateConstraint =  " WHERE
                                EVENTS.FechaHoraInicio >= '$from' ";
        }
        elseif ($to)
        {
            $dateConstraint =  " WHERE
                                EVENTS.FechaHoraFin <= '$to' ";
        }

        $query = "SELECT *
                                FROM (
                                SELECT
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
                                    CS.stars
                                FROM EVENT_API EA
                                LEFT JOIN
                                    (SELECT * FROM FAVORITE_EVENT_USER FE WHERE FE.eventFromApi = 1) as FEU ON EA.idEvento = FEU.idEvento
                                LEFT JOIN
                                    (SELECT AVG (C.stars) AS stars, C.idEvent
                                        FROM COMMENT C
                                        LEFT JOIN COMMENT_STATUS S ON C.idCommentStatus = S.id
                                        WHERE C.eventFromApi = 1 AND S.description LIKE 'Aprobado'
                                        GROUP BY idEvent) as CS ON EA.idEvento = CS.idEvent

                                UNION  ALL
                                SELECT
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
                                    CS.stars
                                FROM   EVENT E
                                LEFT JOIN
                                    (SELECT * FROM FAVORITE_EVENT_USER FE WHERE FE.eventFromApi = 0) as FEU ON E.id = FEU.idEvento
                                LEFT JOIN
                                    (SELECT AVG (C.stars) AS stars, C.idEvent
                                        FROM COMMENT C
                                        LEFT JOIN COMMENT_STATUS S ON C.idCommentStatus = S.id
                                        WHERE C.eventFromApi = 0 AND S.description LIKE 'Aprobado'
                                        GROUP BY idEvent) as CS ON E.id = CS.idEvent
                                WHERE E.Active = 1) EVENTS ".$dateConstraint." ORDER BY EVENTS.FechaHoraInicio";



        return $this->dataBase->query($query);
    }

    public final function addEvent($event)
    {
        return $this->dataBase->query("insert into EVENT (IdUser, Active, Altura, Calle, DescripcionCalendario, DescripcionEvento, Destacado, DetalleTexto, DireccionEvento, FechaHoraFin, FechaHoraInicio, Frecuencia, IdArea, IdCalendario, IdEvento, IdSubarea, Latitud, Longitud, Lugar, NombreArea, NombreCalendario, NombreEvento, NombreSubAreaFormat, NombreSubArea, Precio, Repetir, RutaImagen, RutaImagenMiniatura, TodoDia, ZonaHoraria ) values ('$event->getIdUser()', '$event->getActive()', '$event->getHeight()', '$event->getStreet()', '$event->getDescriptionCalendar()', '$event->getDescriptionEvent()', '$event->getStar()', '$event->getDetailText()', '$event->getEventAddress()', '$event->getDateEnd()', '$event->getDateStart()', '$event->getFrecuency()', '$event->getIdArea()', '$event->getIdCalendar()', '$event->getIdEvent()', '$event->getIdSubarea()', '$event->getLatitude()', '$event->getLength()', '$event->getPlace()', '$event->getNameArea()', '$event->getNameCalendar()', '$event->getNameEvent()', '$event->getNameSubAreaFormat()', '$event->getNameSubarea()', '$event->getPrice()', '$event->getRepeat()', '$event->getImageUrl()', '$event->getImageUrlSmall()', '$event->getAllDay()', '$event->getTimeZone()',     )");
    }

    public final function getEventById($id)
    {
        return $this->dataBase->query("select * from `EVENT` WHERE Id = $id");
    }

    public final function updateEvent($event)
    {
        $query = "update EVENT set 'IdUser'='$event->getIdUser()', 'Active'='$event->getActive()', 'Altura'='$event->getHeight()', 'Calle'='$event->getStreet()', 'DescripcionCalendario'='$event->getDescriptionCalendar()', 'DescripcionEvento'='$event->getDescriptionEvent()', 'Destacado'='$event->getStar()', 'DetalleTexto'='$event->getDetailText()', 'DireccionEvento'='$event->getEventAddress()', 'FechaHoraFin'='$event->getDateEnd()', 'FechaHoraInicio'='$event->getDateStart()', 'Frecuencia'='$event->getFrecuency()', 'IdArea'='$event->getIdArea()', 'IdCalendario'='$event->getIdCalendar()', 'IdEvento'='$event->getIdEvent()', 'IdSubarea'='$event->getIdSubarea()', 'Latitud'='$event->getLatitude()', 'Longitud'='$event->getLength()', 'Lugar'='$event->getPlace()', 'NombreArea'='$event->getNameArea()', 'NombreCalendario'='$event->getNameCalendar()', 'NombreEvento'='$event->getNameEvent()', 'NombreSubAreaFormat'='$event->getNameSubAreaFormat()', 'NombreSubArea'='$event->getNameSubarea()', 'Precio'='$event->getPrice()', 'Repetir'='$event->getRepeat()', 'RutaImagen'='$event->getImageUrl()', 'RutaImagenMiniatura'='$event->getImageUrlSmall()', 'TodoDia'='$event->getAllDay()', 'ZonaHoraria'='$event->getTimeZone()',  where 'Id'='$event->getId()'";
        return $this->dataBase->query($query);
    }

    public final function deleteEvent($id)
    {
        return $this->dataBase->query("update EVENT set Active = '0' where Id = '$id'");
    }

}