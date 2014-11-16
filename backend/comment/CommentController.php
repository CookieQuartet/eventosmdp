<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

include_once('CommentQueries.php');
include_once('../database/DataBase.php');

class CommentController {

    private $commentQueries;

    function __construct()
    {
        $this->commentQueries = new CommentQueries();
    }


    public function invoke()
    {
        $return = "";
        if (!isset($_GET['method'])) {
            $return = '{ "error": "No se envió un método" }';
        } else {

            $ownEvents= Event::getEventQueries()->getOwnEventsList();

            switch($_GET['method']) {
                case 'add_review':
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
                case 'get_reviews':
                    if (!isset($_GET['event']) || !isset($_GET['fromAPI']))
                    {
                        $return = '{ "error": "Parametros incorrectos" }';
                    }
                    else
                    {
                        $return = getReviewsByEvent($_GET['event'], $_GET['fromAPI']);
                    }
                    break;
            }
        }
        echo $return;
    }


    public function getReviewsByEvent($eventId, $eventFromApi)
    {
        $comments= $this->commentQueries->getCommentListForEvent($eventId, $eventFromApi);
        return DataBase::fetchQueryResultToJson($comments);
    }

}
