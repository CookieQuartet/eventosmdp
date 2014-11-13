<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

include_once('./Comment.php');

class CommentController {

    public function invoke()
    {
        $return = "";
        if (!isset($_GET['method'])) {
            $return = '{ "error": "No se envió un método" }';
        } else {

            $ownEvents= Event::getEventQueries()->getOwnEventsList();

            switch($_GET['method']) {
                case 'add':
//                    $_SESSION["user"] = UserFactory::getInstance()->register($_GET['email'], $_GET['password'], 2);
//                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
//                        $return = json_encode($_SESSION["user"]->getUserData());
//                    } else {
//                        $return = '{ "success": true, "message": "Ya existe un usuario registrado con ese email" }';
//                    }
                    break;
                case 'login':

                    break;
                case 'check':

                    break;
                case 'edit':

                    break;
                case 'delete':

                    break;
                case 'approve':

                    break;
                case 'report':

                    break;
                case 'pendingList':

                    break;
                case 'reportedList':

                    break;
                case 'commentListForEvent':

                    break;

            }
        }
        echo $return;
    }

} 