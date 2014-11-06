<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */
include('../database/DataBase.php');


class CommentQueries {

    private $dataBase;

    function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public final function getCommentList() //Lista de Comentarios Completa
    {
        $commentQuery = "select CO.*,SC.description from COMMENT CO, STATUS_COMMENT SC where CO.idStatusComment = SC.id";
        return $this->dataBase->query($commentQuery);
    }

    public final function getCommentListPending() //Lista de Comentarios Pendientes
    {
        $commentQuery = "select CO.*,SC.description from COMMENT CO, STATUS_COMMENT SC where CO.idStatusComment = SC.id and SC.id = 1";
        return $this->dataBase->query($commentQuery);
    }

    public final function getCommentListReported() //Lista de Comentarios Denunciados
    {
        $commentQuery = "select CO.*,SC.description from COMMENT CO, STATUS_COMMENT SC where CO.idStatusComment = SC.id and SC.id = 3";
        return $this->dataBase->query($commentQuery);
    }

    public final function getCommentListForEvent($idEvent) //Lista de Comentarios Aprobados para un Evento
    {
        $commentQuery = "select CO.*,SC.description from COMMENT CO, STATUS_COMMENT SC where CO.idStatusComment = SC.id  and SC.id = 2 and CO.id_event = '$idEvent'";
        return $this->dataBase->query($commentQuery);
    }

    public final function addComment($comment)
    {
        $commentQuery = "insert into COMMENT (text, idStatusComment, id_event, stars) values ('$comment->getText()' , '$comment->getIdCommentStatus()', '$comment->getIdEvent()', '$comment->getStars()' )";
        return $this->dataBase->query($commentQuery);
    }

    public final function updateComment($comment)
    {
        $commentQuery = "update COMMENT set text='$comment->getText()', idStatusComment='$comment->getIdCommentStatus()', id_event='$comment->getIdEvent()', stars='$comment->getStars()' where id='$comment->getId()'";
        return $this->dataBase->query($commentQuery);
    }

    public final function approveComment($id) //Set Comentario Aprobado
    {
        $commentQuery = "update COMMENT set idStatusComment = '2' where id = '$id'";
        return $this->dataBase->query($commentQuery);
    }

    public final function reportComment($id) //Set Comentario Denunciado
    {
        $commentQuery = "update COMMENT set idStatusComment = '3' where id = '$id'";
        return $this->dataBase->query($commentQuery);
    }

    public final function deleteComment($id) //Set Comentario Eliminado
    {
        $commentQuery = "update COMMENT set idStatusComment = '4' where id = '$id'";
        return $this->dataBase->query($commentQuery);
    }

    public final function getCommentById($id)
    {
        $commentQuery = "select * from COMMENT WHERE id = '$id'";
        return $this->dataBase->query($commentQuery);
    }
} 