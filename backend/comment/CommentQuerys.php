<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

class CommentQuerys {
    public final static function getCommentList($connection) //Lista de Usuarios
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

            $commentQuery = "insert into COMMENT (id, text, id_comment_status, id_event, stars) values ('$comment->getId()' , '$comment->getText()' , '$comment->getIdCommentStatus()', '$comment->getIdEvent()', '$comment->getStars()' )";
            mysqli_query($connection, $commentQuery);

        } catch (Exception $e) {
            echo ($e);
        }
    }

    public final static function updateComment($connection, Comment $comment)
    {
        try {

            $commentQuery = "update COMMENT set 'id'=$comment->getId(), 'text'=$comment->getText(), 'id_comment_status'=$comment->getIdCommentStatus, 'id_event'=$comment->getIdEvent(), 'stars'=$comment->getStars() where 1";
            mysqli_query($connection, $commentQuery);

        } catch (Exception $e) {
            echo ($e);
        }
    }

} 