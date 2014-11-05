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

    public final function getEventList()
    {
        return $this->dataBase->query("select * from EVENT");
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