<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

include_once('EventQueries.php');
include_once('../user/UserFactory.php');
include_once('../utils/Strings.php');

class EventController {

    private $eventQueries;

    function __construct()
    {
        $this->eventQueries = new EventQueries();
    }

    public function invoke()
    {
        $return = "";
        if (!isset($_GET['method']))
        {
            $return = '{ "error": "No se envió un método" }';
        } else {
            switch($_GET['method'])
            {
                case 'get_events':
                        $from = isset($_GET['from'])? $_GET['from']:null;
                        $to = isset($_GET['to'])? $_GET['to']:null;
                        $return = $this->getEvents($from, $to);
                    break;
                case 'add_event':
                    //$return = $this->newEvent($from, $to);
                    break;
                case 'get_reviews':

                    break;
                case 'add_event':
                    if (!isset($_GET['DescripcionEvento']) || !isset($_GET['DetalleTexto']) || !isset($_GET['DireccionEvento'])
                        || !isset($_GET['FechaHoraFin']) || !isset($_GET['FechaHoraInicio']) || !isset($_GET['IdArea'])
                        || !isset($_GET['IdCalendario']) || !isset($_GET['IdSubarea']) || !isset($_GET['Lugar'])
                        || !isset($_GET['NombreEvento']) || !isset($_GET['Precio']) || !isset($_GET['RutaImagen'])
                        || !isset($_GET['ZonaHoraria']))
                    {
                        $return = '{ "error": "Parametros incorrectos" }';
                    }
                    else
                    {
                        $return = newEvent($_GET['DescripcionEvento'], $_GET['DetalleTexto'], $_GET['DireccionEvento'],
                                           $_GET['FechaHoraFin'], $_GET['FechaHoraInicio'], $_GET['IdArea'],
                                           $_GET['IdCalendario'], $_GET['IdSubarea'], $_GET['Lugar'],
                                           $_GET['NombreEvento'], $_GET['Precio'], $_GET['RutaImagen'],
                                           $_GET['ZonaHoraria']);
                    }
                    break;
                case 'remove_favorite':

                    break;
                case 'add_favorite':

                    break;

            }
        }
        echo $return;
    }

    public function getEvents($from, $to)
    {
        $eq = $this->eventQueries;
        $rows = $eq->getEvents($from, $to);
        //$result = $rows->fetch_all(MYSQLI_ASSOC);
        $result = $eq->fetch_all($rows);
        return json_encode($result);
    }

    public function newEvent($descripcionEvento, $detalleTexto, $direccionEvento, $fechaHoraFin, $fechaHoraInicio, $idArea, $idCalendario, $idSubarea, $lugar, $nombreEvento, $precio, $rutaImagen, $zonaHoraria)
    {
        $result= $this->eventQueries->addEvent(UserFactory::getInstance()->getId(), true, $descripcionEvento, $detalleTexto, $direccionEvento, $fechaHoraFin, $fechaHoraInicio, $idArea, $idCalendario, $idSubarea, $lugar, $nombreEvento, $precio, $rutaImagen, $zonaHoraria);
        if ($result)
        {
            return "{\"status\": \"".sucessfull."\" , \"message\": \"Evento agregado\"}";
        }
        else
        {
            return "{\"status\": \"".error."\" , \"message\": \"Error al agregar evento\"}";
        }

    }

    public function updateEvent()
    {

    }
}