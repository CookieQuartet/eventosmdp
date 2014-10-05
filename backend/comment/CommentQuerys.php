<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

class CommentQuerys {
    public final static function getCommentList($connection) //Lista de Comentarios
    {

        try {
            $comment = $connection->query ("select * from COMMENT");
        } catch (Exception $e) {
            echo ($e);
        }

        return $comment;
    }

    public final static function addComment($connection, Comment $comment)
    {
        try {

            $commentQuery = "insert into COMMENT (text, id_comment_status, id_event, stars) values ('$comment->getText()' , '$comment->getIdCommentStatus()', '$comment->getIdEvent()', '$comment->getStars()' )";
            mysqli_query($connection, $commentQuery);

        } catch (Exception $e) {
            echo ($e);
        }
    }

    public final static function updateComment($connection, $comment)
    {
        try {

            $commentQuery = "update COMMENT set 'text'=$comment->getText(), 'id_comment_status'=$comment->getIdCommentStatus, 'id_event'=$comment->getIdEvent(), 'stars'=$comment->getStars() where 'id'=$comment->getId()";
            mysqli_query($connection, $commentQuery);

        } catch (Exception $e) {
            echo ($e);
        }
    }

    public final static function deleteComment($connection, $id)
    {

        try {

            $commentQuery = "update COMMENT set active = '0' where id = '$id'";
            mysqli_query($connection, $commentQuery);

        } catch (Exception $e) {
            echo ($e);
        }

    }

    public final static function getCommentById($connection, $id)
    {

        try {
            $comment = $connection->query("select * from `COMMENT` WHERE id = $id");
        } catch (Exception $e) {
            echo($e);
        }

        return $comment;
    }
} 