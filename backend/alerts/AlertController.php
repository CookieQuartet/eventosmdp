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

include_once('AlertQueries.php');
include_once('../utils/Strings.php');

class AlertController {

    private $alertQueries;

    function __construct()
    {
        $this->alertQueries = new AlertQueries();
    }

    public function invoke()
    {
        $return = "";
        if (!isset($_GET['method'])) {
            $return = '{ "error": "No se envió un método" }';
        } else {
            switch($_GET['method']) {
                case 'add_alert':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $user = $_SESSION["user"]->getUserData();
                        $return = $this->addAlert($user['id'], $postData->alert);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'delete_alert':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $return = $this->deleteAlert($postData->alert);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                    break;
                case 'update_alert':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $return = $this->updateAlert($postData->alert);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'get_alerts':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $user = $_SESSION["user"]->getUserData();
                        $return = $this->getAlerts($user['id']);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
            }
        }
        echo $return;
    }

    public function sendAlerts()
    {
        // obtener la lista de usuarios con alertas definidas
        // por cada usuario:
        //  obtener la lista de alertas para el dia siguiente (decision de implementacion)
        //  generar el texto del mail
        //  enviar el mail
        echo('done');
    }

    public function getAlerts($userId)
    {
        $cq = $this->alertQueries;
        $rows= $cq->getAlerts($userId);
        $result = $cq->fetch_all($rows);
        return json_encode($result);
    }

    public function addAlert($userId, $alert)
    {
        $result= $this->alertQueries->addAlert($userId, $alert);
        return json_encode($result);
    }

    public function deleteAlert($alert)
    {
        $result= $this->alertQueries->deleteAlert($alert);

        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Alerta eliminada\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al eliminar alerta\"}";
        }
    }

    public function updateAlert($alert)
    {
        $result= $this->alertQueries->updateAlert($alert);

        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Alerta modificada\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al modificar alerta\"}";
        }
    }

}