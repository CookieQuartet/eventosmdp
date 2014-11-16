<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

include_once('../user/User.php');
include_once('../user/userAdmin/UserAdmin.php');
include_once('../user/userGeneral/UserGeneral.php');
include_once('../user/userPublisher/UserPublisher.php');
include_once('../user/userType/UserTypeEnum.php');
include_once('../user/UserFactory.php');

include_once('EventQueries.php');
//include_once('../user/UserFactory.php');
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
                case 'get_reviews':

                    break;
                case 'add_event':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $user = $_SESSION["user"]->getUserData();
                        $return = $this->newEvent($user['id'], $postData);
                    } else {
                        $return = '{ "status": "error", "message": "Error obteniendo los usuarios" }';
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
        $result = $eq->fetch_all($rows);
        return json_encode($result);
    }

    public function newEvent($user, $data)
    {
        $result= $this->eventQueries->addEvent(
            $user,
            true,
            $data->DescripcionEvento,
            $data->DetalleTexto,
            $data->DireccionEvento,
            $data->FechaHoraFin,
            $data->FechaHoraInicio,
            //$data->IdArea,
            $data->IdCalendario,
            $data->IdSubarea,
            $data->Lugar,
            $data->NombreEvento,
            $data->Precio,
            $data->RutaImagen,
            $data->ZonaHoraria
        );
        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Evento agregado\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al agregar evento\"}";
        }
    }

    public function updateEvent()
    {

    }
}