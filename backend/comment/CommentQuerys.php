<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */
include('../database/DataBase.php');


class CommentQuerys {

    private $dataBase;

    function __construct()
    {
        $this->$dataBase = new DataBase();
    }

    public final function getCommentList() //Lista de Comentarios
    {
        return $this->$dataBase->query("select * from COMMENT");
    }

    public final function addComment(Comment $comment)
    {
        $commentQuery = "insert into COMMENT (text, id_status_comment, id_event, stars) values ('$comment->getText()' , '$comment->getIdCommentStatus()', '$comment->getIdEvent()', '$comment->getStars()' )";
        return $this->$dataBase->query($commentQuery);
    }

    public final function updateComment($comment)
    {
        $commentQuery = "update COMMENT set 'text'=$comment->getText(), 'id_status_comment'=$comment->getIdCommentStatus, 'id_event'=$comment->getIdEvent(), 'stars'=$comment->getStars() where 'id'=$comment->getId()";
        return $this->$dataBase->query($commentQuery);
    }

    public final function deleteComment($id)
    {
        $commentQuery = "update COMMENT set active = '0' where id = '$id'";
        return $this->$dataBase->query($commentQuery);
    }

    public final function getCommentById($id)
    {
        return $this->$dataBase->query("select * from `COMMENT` WHERE id = $id");
    }
} 