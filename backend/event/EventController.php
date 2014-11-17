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
                case 'get_event':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $user = $_SESSION["user"]->getUserData();
                        if ($user['type'] == UserTypeEnum::UserAdminType || $user['type'] == UserTypeEnum::UserPublisherType) {
                            $return = $this->getEvent($user['id'], $_GET['id']);
                        } else {
                            $return = '{ "status": "error", "message": "No tiene permisos sobre este evento" }';
                        }
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'get_events':
                    $from = isset($_GET['from'])? $_GET['from']:null;
                    $to = isset($_GET['to'])? $_GET['to']:null;
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $user = $_SESSION["user"]->getUserData();
                        $idUser = $user['id'];
                    } else {
                        $idUser = null;
                    }
                    $return = $this->getEvents($idUser, $from, $to);
                    break;
                case 'get_my_events':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $user = $_SESSION["user"]->getUserData();
                        if ($user['type']==UserTypeEnum::UserAdminType || $user['type']==UserTypeEnum::UserPublisherType)
                        {
                            $postData = json_decode(file_get_contents("php://input"));
                            $return = $this->getMyEvents($user['id'], $postData);
                        }
                        else
                        {
                            $return = '{ "status": "error", "message": "Debe ser usuario publicador o administrador" }';
                        }
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'add_event':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $user = $_SESSION["user"]->getUserData();
                        if ($user['type']==UserTypeEnum::UserAdminType || $user['type']==UserTypeEnum::UserPublisherType)
                        {
                            $postData = json_decode(file_get_contents("php://input"));
                            $return = $this->newEvent($user['id'], $postData);
                        }
                        else
                        {
                            $return = '{ "status": "error", "message": "Debe ser usuario publicador o administrador" }';
                        }
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'edit_event':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $user = $_SESSION["user"]->getUserData();
                        if ($user['type'] == UserTypeEnum::UserAdminType || $user['type'] == UserTypeEnum::UserPublisherType)
                        {
                            $postData = json_decode(file_get_contents("php://input"));
                            $return = $this->editEvent($postData);
                        }
                        else
                        {
                            $return = '{ "status": "error", "message": "Debe ser usuario publicador o administrador" }';
                        }
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'remove_event':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $user = $_SESSION["user"]->getUserData();
                        if ($user['type'] == UserTypeEnum::UserAdminType || $user['type'] == UserTypeEnum::UserPublisherType) {
                            $postData = json_decode(file_get_contents("php://input"));
                            $return = $this->removeEvent($user, $postData);
                        } else {
                            $return = '{ "status": "error", "message": "Debe ser usuario publicador o administrador" }';
                        }
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'remove_favorite':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $user = $_SESSION["user"]->getUserData();
                        $return = $this->removeFavorite($user['id'], $postData);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'add_favorite':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $user = $_SESSION["user"]->getUserData();
                        $return = $this->addFavorite($user['id'], $postData);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
            }
        }
        echo $return;
    }

    public function getEvent($idUser, $idEvento)
    {
        $eq = $this->eventQueries;
        $rows = $eq->getEvent($idUser, $idEvento);
        $result = $rows->fetch_assoc();
        return json_encode($result);
    }

    public function getEvents($user, $from, $to)
    {
        $eq = $this->eventQueries;
        $rows = $eq->getEvents($user, $from, $to);
        $result = $eq->fetch_all($rows);
        return json_encode($result);
    }

    public function getMyEvents($user)
    {
        $eq = $this->eventQueries;
        $rows = $eq->getMyEvents($user);
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

    public function editEvent($event)
    {
        $result= $this->eventQueries->updateEvent(
            $event->Id,
            $event->DescripcionEvento,
            $event->DetalleTexto,
            $event->DireccionEvento,
            $event->FechaHoraFin,
            $event->FechaHoraInicio,
            $event->Lugar,
            $event->NombreEvento,
            $event->Precio,
            $event->RutaImagen,
            $event->ZonaHoraria
        );
        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Evento modificado\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al modificar evento\"}";
        }
    }

    public function removeEvent($user, $event)
    {
        $result= $this->eventQueries->deleteEvent($event->Id);
        if($result) {
            return $this->getMyEvents($user['id']);
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al eliminar evento\"}";
        }
    }

    public function addFavorite($user, $event) {
        $idEvento = $event->IdEvento ? $event->IdEvento : $event->Id;
        $fromAPI = $event->fromAPI;

        $result = $this->eventQueries->addFavorite($user, $idEvento, $fromAPI);
        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Se agregó a favoritos\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al agregar favorito\"}";
        }
    }

    public function removeFavorite($user, $event) {
        $idEvento = $event->IdEvento ? $event->IdEvento : $event->Id;
        $result = $this->eventQueries->removeFavorite($user, $idEvento);
        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Se eliminó de favoritos\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al eliminar favorito\"}";
        }
    }

}