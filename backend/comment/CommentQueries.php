<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */
include_once('../database/DataBase.php');


class CommentQueries {

    private $dataBase;

    function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public function fetch_all($rows) {
        return $this->dataBase->fetch_all($rows);
    }

    //Lista de Comentarios Completa
    public final function getCommentList()
    {
        $commentQuery = "select CO.*,CS.description,UR.name,UR.email from COMMENT CO, COMMENT_STATUS CS, USER UR where CO.idCommentStatus = CS.id and CO.idUser = UR.id";
        return $this->dataBase->query($commentQuery);
    }

    //Lista de Comentarios Pendientes
    public final function getCommentListPending()
    {
        $commentQuery = "select CO.*,CS.description,UR.name,UR.email from COMMENT CO, COMMENT_STATUS CS, USER UR where CO.idCommentStatus = CS.id and CS.id = '1' and CO.idUser = UR.id";
        return $this->dataBase->query($commentQuery);
    }

    //Lista de Comentarios Denunciados
    public final function getCommentListReported()
    {
        $commentQuery = "select CO.*,CS.description,UR.name,UR.email from COMMENT CO, COMMENT_STATUS CS, USER UR where CO.idCommentStatus = CS.id and CS.id = '3' and CO.idUser = UR.id";
        return $this->dataBase->query($commentQuery);
    }

    //Lista de Comentarios Aprobados para un Evento, por usuarios activos Activo
    //public final function getCommentListForEvent($idEvent, $eventFromApi)
    public final function getCommentListForEvent($idEvent)
    {
        $commentQuery = "
          select
            CO.*
            , CS.description
            , UR.name
          from
            COMMENT CO,
            COMMENT_STATUS CS,
            USER UR
          where
            CO.idCommentStatus = CS.id
            and CO.idEvent = $idEvent
            and CO.idUser = UR.id
            and UR.active = '1'";
        return $this->dataBase->query($commentQuery);
    }

    //Insertar Comentario. Si 'idCommentStatus' pasa null, por defecto se marca Pendiente. Si es ADMIN, idCommentStatus = Aprobado 2
    public final function addComment($user, $eventId, $commentText, $commentStatus, $fromApi, $rating)
    {
        $commentQuery = "
            insert into COMMENT (
                idUser,
                text,
                idCommentStatus,
                idEvent,
                eventFromApi,
                stars
            )
            values ($user, '$commentText', $commentStatus, $eventId, $fromApi, $rating)";
        return $this->dataBase->query($commentQuery);
    }

    //Update completo de Comentario
    public final function updateComment($comment)
    {
        $commentQuery = "update COMMENT set text='$comment->getText()', idCommentStatus='$comment->getIdCommentStatus()', stars='$comment->getStars()' where id='$comment->getId()'";
        return $this->dataBase->query($commentQuery);
    }

    //Update CommentStatus del Comentario: Aprobado 2, Denunciado 3, Eliminado 4
    public final function updateCommentStatus($id,$idCommentStatus)
    {
        $commentQuery = "update COMMENT set idCommentStatus = '$idCommentStatus' where id = '$id'";
        return $this->dataBase->query($commentQuery);
    }

    //Obtiene info de un Comentario
    public final function getCommentById($id)
    {
        $commentQuery = "select CO.*,CS.description,UR.name,UR.email from COMMENT CO, COMMENT_STATUS CS, USER UR where CO.idCommentStatus = CS.id and CO.idUser = UR.id and CO.id = '$id'";
        return $this->dataBase->query($commentQuery);
    }
} 