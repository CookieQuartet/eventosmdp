<?php

include_once('User.php');
include_once('userAdmin/UserAdmin.php');
include_once('userGeneral/UserGeneral.php');
include_once('userPublisher/UserPublisher.php');
include_once('userType/UserTypeEnum.php');
include_once('UserFactory.php');


class UserController {
    public function invoke()
    {
        $return = "";
        if (!isset($_GET['method'])) {
            $return = '{ "error": "No se envió un método" }';
        } else {
            switch($_GET['method']) {
                case 'register':
                    $_SESSION["user"] = UserFactory::getInstance()->register($_GET['email'], $_GET['password'], 3);
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $return = json_encode($_SESSION["user"]->getUserData());
                    } else {
                        $return = '{ "logged": false, "error": "Ya existe un usuario registrado con ese email" }';
                    }
                    break;
                case 'create':
                    $name = $_GET['name'];
                    $email = $_GET['email'];
                    $type =  $_GET['type'];
                    $password =  $_GET['password'];

                    $user = UserFactory::getInstance()->create($email, $name, $password, $type);
                    if(isset($user) && $user) {
                        $return = '{ "status": "ok", "message": "Se creó el usuario" }';
                    } else {
                        $return = '{ "logged": false, "error": "Ya existe un usuario registrado con ese email" }';
                    }
                    break;
                case 'login':
                    $_SESSION["user"] = UserFactory::getInstance()->login($_GET['email'], $_GET['password']);
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $return = json_encode($_SESSION["user"]->getUserData());
                    } else {
                        $return = '{ "logged": false, "error": "Error de email / password" }';
                    }
                    break;
                case 'users':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $rows = $_SESSION["user"]->getUserQueries()->getUserList();
                        /*$result = array();
                        while ($row = $rows->fetch_assoc()) {
                            array_push($result, $row);
                        }
                        $rows->free();*/

                        $result = $rows->fetch_all(MYSQLI_ASSOC);
                        $return = json_encode($result);
                        $rows->free();
                    } else {
                        $return = '{ "logged": false, "error": "Error obteniendo los usuarios" }';
                    }
                    break;
                case 'user':
                    if(isset($_SESSION["user"]) && $_SESSION["user"] && isset($_GET["id"])) {
                        $rows = $_SESSION["user"]->getUserQueries()->getUserById($_GET["id"]);
                        /*$result = array();
                        while ($row = $rows->fetch_assoc()) {
                            array_push($result, $row);
                        }
                        $rows->free();
                        $return = json_encode($result);*/

                        $result = $rows->fetch_object(MYSQLI_ASSOC);
                        $return = json_encode($result);
                        $rows->free();


                    } else {
                        $return = '{ "logged": false, "error": "Error obteniendo el usuario" }';
                    }
                    break;
                case 'update':
                    if(isset($_SESSION["user"]) && $_SESSION["user"] && isset($_GET["id"])) {
                        $email = $_GET["email"];
                        $id = $_GET["id"];
                        $name = $_GET["name"];
                        $password = $_GET["password"];
                        $active = $_GET["active"];
                        $type = $_GET["type"];
                        $rows = $_SESSION["user"]->getUserQueries()->updateUser($email, $id, $name, $password, $active, $type);
                        $return = json_encode($rows);
                    } else {
                        $return = '{ "logged": false, "error": "Error actualizando el usuario" }';
                    }
                    break;
                case 'toggle':
                    if(isset($_SESSION["user"]) && $_SESSION["user"] && isset($_GET["id"])) {
                        $id = $_GET["id"];
                        $active = $_GET["active"];
                        $rows = $_SESSION["user"]->getUserQueries()->toggleUser($id, $active);
                        $return = json_encode($rows);
                    } else {
                        $return = '{ "logged": false, "error": "Error actualizando el usuario" }';
                    }
                    break;
                case 'check':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $return = json_encode($_SESSION["user"]->getUserData());
                    } else {
                        $return = '{ "logged": false, "error": "No se ha iniciado sesión" }';
                    }
                    break;
                case 'logout':
                    session_destroy();
                    $return = '{ "logged": false, "message": "Sesión cerrada" }';
                    break;
            }
        }
        echo $return;
    }
}
