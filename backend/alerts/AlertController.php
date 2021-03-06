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
        function mailHeader($user, $mail, $fecha) {
            $f = date_format($fecha, 'd/m/Y');
            return "
                <div style='float:left;width:100%;'>
                    <h1 style='font-size: 1.5em;'>EventosMDP</h1>
                    <h2 style='font-size: 1.2em;'>Resumen de las alertas de eventos para mañana</h2>
                    <div style='float: left;border:1px solid orange;background: lightyellow;padding:4px;margin-bottom:10px;'>
                        <div style='font-weight: bold;float: left;width: 70px;text-align: right;margin-right: 10px;'>Usuario:</div> $user
                        <br>
                        <div style='font-weight: bold;float: left;width: 70px;text-align: right;margin-right: 10px;'>Email:</div> $mail
                        <br>
                        <div style='font-weight: bold;float: left;width: 70px;text-align: right;margin-right: 10px;'>Fecha:</div> $f
                        <br>
                    </div>
                </div>
                <hr>
                ";
        }
        function mailBody($alerts) {
            $text = '';
            foreach($alerts as $alert => $event) {
                $keyword = $event['keyword'];
                $name = $event['NombreEvento'];
                $descr = $event['DescripcionEvento'];
                $event = "
                    <div>
                        <div style='color:blue; padding:4px;'>
                            [keywords=<span class='event_keyword' style='color:red;'>$keyword</span>]
                        </div>
                        <div style='font-weight: bold; font-size: 1.2em; padding:4px;'>$name</div>
                        <div style='padding:4px;'>$descr</div>
                    </div>
                    <hr>
                ";
                $text = $text.$event;
            }
            return $text;
        }
        function mailFooter() {
            return "
                <span style='font-size: 0.8em; padding-left:4px;'>
                    <!--Para más información ingresá en <a href='http://localhost/eventos'>EventosMDP</a>-->
                    Para más información ingresá en <a href='http://eventosmdp.890m.com/public_html/#/events'>EventosMDP</a>
                </span>
                <hr>
            ";
        }
        function mailHTMLFormat($header, $body) {
            $footer = mailFooter();
            return "
                <html style='font-family: sans-serif;'>
                    <head></head>
                    <body>
                        $header
                        $body
                        $footer
                    </body>
                </html>
            ";
        }
        // obtener la lista de usuarios con alertas definidas
        $rows= $this->alertQueries->getUsersWithAlerts();
        $result = $this->alertQueries->fetch_all($rows);

        // definir rango de dias
        $zh = new DateTimeZone("America/Argentina/Buenos_Aires");
        $from = date_create('tomorrow', $zh);
        $to = date_create('tomorrow +1 day', $zh);

        // por cada usuario:
        foreach($result as $item => $usuario) {
            //  obtener la lista de alertas para el dia siguiente (decision de implementacion)
            $rows = $this->alertQueries->getEventAlerts($usuario['id_user'], date_format($from, 'Ymd\THis'), date_format($to, 'Ymd\THis'));
            $alerts = $this->alertQueries->fetch_all($rows);
            if(count($alerts)) {
                //  generar el texto del mail
                $mheader = mailHeader($usuario['name'], $usuario['email'], $from);
                $mbody = mailBody($alerts);
                $mail = mailHTMLFormat($mheader, $mbody);
                //  enviar el mail
                $headers =
                    'From: EventosMDP <eventosmdp@eventosmdp.890m.com>' . "\r\n".
                    'Reply-To: eventosmdp@eventosmdp.890m.com' . "\r\n" .
                    'MIME-Version: 1.0' . "\r\n".
                    'Content-type: text/html; charset=utf-8' . "\r\n".
                    'X-Mailer: PHP/' . phpversion();
                if (mail($usuario['email'], 'Alertas de EventosMDP', $mail, $headers)) {
                    echo '<div style="border:1px solid green;background: lightgreen;font-weight:bold;float:left;width:100%;">OK</div> ';
                } else {
                    echo '<div style="border:1px solid red; background: pink;font-weight:bold;float:left;width:100%;">Error</div> ';
                }
                echo($mail);
            }
        }
    }

    public function getAlerts($userId)
    {
        $cq = $this->alertQueries;
        $rows= $cq->getAlerts($userId);
        return json_encode($cq->fetch_all($rows));
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