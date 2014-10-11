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
                case 'login':
                    $_SESSION["user"] = UserFactory::getInstance()->login($_GET['email'], $_GET['password']);
                    if($_SESSION["user"]) {
                        $return = json_encode($_SESSION["user"]->getUserData());
                    } else {
                        $return = '{ "error": "Error de usuario" }';
                    }
                    break;
                case 'check':
                    if(isset($_SESSION["user"])) {
                        //var_dump($_SESSION["user"]);
                        $return = json_encode($_SESSION["user"]->getUserData());
                    } else {
                        $return = '{ "id": 0 }';
                    }
                    break;
                case 'logout':
                    session_destroy();
                    $return = '{ "logged": false }';
                    break;
            }
        }
        echo $return;
    }
}
