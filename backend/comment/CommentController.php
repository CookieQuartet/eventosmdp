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

include_once('CommentQueries.php');
include_once('CommentStatusEnum.php');
//include_once('../user/UserFactory.php');
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
                case 'reactivate':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        $return = $this->reactivateReview($postData);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'report':
                    if(isset($_SESSION["user"]) && $_SESSION["user"]) {
                        $postData = json_decode(file_get_contents("php://input"));
                        //$user = $_SESSION["user"]->getUserData();
                        $return = $this->reportReview($postData);
                    } else {
                        $return = '{ "status": "error", "message": "Debe iniciar sesión" }';
                    }
                    break;
                case 'pendingList':

                    break;
                case 'reportedList':

                    break;
                case 'get_reviews':
                    $postData = json_decode(file_get_contents("php://input"));
                    $return = $this->getReviewsByEvent($postData);
                    break;
            }
        }
        echo $return;
    }


    public function getReviewsByEvent($event)
    {
        $cq = $this->commentQueries;
        //$rows= $cq->getCommentListForEvent($event->EventId, $event->EventFromApi);
        $id = $event->IdEvento ? $event->IdEvento : $event->Id;
        $rows= $cq->getCommentListForEvent($id);
        //$result = $rows->fetch_all(MYSQLI_ASSOC);
        $result = $cq->fetch_all($rows);
        return json_encode($result);
    }

    public function addReview($userId, $review)
    {
        if(!$review->event->IdEvento) {
            $id = $review->event->Id;
            $fromAPI = 0;
        } else {
            $id = $review->event->IdEvento;
            $fromAPI = 1;
        }
        $result= $this->commentQueries->addComment(
            $userId
            , $id
            , $review->comment->text
            , CommentStatusEnum::Pendiente
            , $fromAPI
            , $review->comment->stars
        );

        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Comentario agregado\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al agregar comentario\"}";
        }
    }

    public function reportReview($review)
    {
        $result= $this->commentQueries->updateCommentStatus($review->comment->id, 3);

        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Comentario reportado\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al reportar comentario\"}";
        }
    }

    public function reactivateReview($review)
    {
        $result= $this->commentQueries->updateCommentStatus($review->comment->id, 1);

        if ($result) {
            return "{\"status\": \"".successfull."\" , \"message\": \"Comentario reactivado\"}";
        } else {
            return "{\"status\": \"".error."\" , \"message\": \"Error al reactivar comentario\"}";
        }
    }

}