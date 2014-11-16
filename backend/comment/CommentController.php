<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

include_once('CommentQueries.php');
include_once('CommentStatusEnum.php');
include_once('../user/UserFactory.php');
include_once('../utils/Strings.php');

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
//                    event:int, fromAPI:bool, comment: string, rating: int
                    if (!isset($_GET['event']) || !isset($_GET['comment']) || !isset($_GET['fromAPI']))
                    {
                        $return = '{ "error": "Parametros incorrectos" }';
                    }
                    else
                    {
                        $rating = isset($_GET['rating'])?($_GET['rating']):0;
                        $return = addReview($_GET['event'], $_GET['comment'], $_GET['fromAPI'], $rating);
                    }
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
        $rows= $this->commentQueries->getCommentListForEvent($eventId, $eventFromApi);
        $result = $rows->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function addReview($eventId, $comment, $fromApi, $rating)
    {
        $result= $this->commentQueries->addComment(UserFactory::getInstance()->getId(),$eventId, $comment, CommentStatusEnum::Pendiente,$fromApi, $rating);
        if ($result)
        {
            echo ($result);
            return "{\"status\": \"".sucessfull."\" , \"message\": \"Comentario agregado\"}";
        }
        else
        {
            return "{\"status\": \"".error."\" , \"message\": \"Error al agregar comentario\"}";
        }
    }

}