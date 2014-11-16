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
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $user = $_SESSION["user"]->getUserData();
                        $return = $this->addReview($user['id'], $postData);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
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
                    {
                        $postData = json_decode(file_get_contents("php://input"));
                        $return = getReviewsByEvent($postData);
                    }
                    break;
            }
        }
        echo $return;
    }


    public function getReviewsByEvent($event)
    {
        $cq = $this->commentQueries;
        $rows= $cq->getCommentListForEvent($event->EventId, $event->EventFromApi);
        //$result = $rows->fetch_all(MYSQLI_ASSOC);
        $result = $cq->fetch_all($rows);
        return json_encode($result);
    }

    public function addReview($userId, $review)
    {
        $result= $this->commentQueries->addComment($userId, $review->EventId, $review->Comment, CommentStatusEnum::Pendiente, $review->FromApi, $review->Rating);
        if ($result)
        {
            return "{\"status\": \"".sucessfull."\" , \"message\": \"Comentario agregado\"}";
        }
        else
        {
            return "{\"status\": \"".error."\" , \"message\": \"Error al agregar comentario\"}";
        }
    }

}