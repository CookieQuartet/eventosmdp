<?php

include_once('./User.php');
include_once('./userAdmin/UserAdmin.php');
include_once('./userGeneral/UserGeneral.php');
include_once('./userPublisher/UserPublisher.php');
include_once('./userType/UserTypeEnum.php');
include_once('./UserFactory.php');


class UserController {
    public function invoke()
    {
        $return = "";
        if (!isset($_GET['method'])) {
            $return = '{ "error": "No se envió un método" }';
        } else {
            switch($_GET['method']) {
                case 'register':
                    $_SESSION["user"] = UserFactory::getInstance()->register($_GET['email'], $_GET['password'], 2);
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $return = json_encode($_SESSION["user"]->getUserData());
                    } else {
                        $return = '{ "logged": false, "error": "Ya existe un usuario registrado con ese email" }';
                    }
                    break;
                case 'login':
                    $_SESSION["user"] = UserFactory::getInstance()->login($_GET['email'], $_GET['password']);
                    if($_SESSION["user"]) {
                        $return = json_encode($_SESSION["user"]->getUserData());
                    } else {
                        $return = '{ "logged": false, "error": "Error de email / password" }';
                    }
                    break;
                case 'check':
                    if(isset($_SESSION["user"])) {
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
