<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:27 PM
 */
class UserQuerys {

    public final static function getUserList($connection) //Lista de Usuarios
    {

        try {
            $users = $connection->query ("select * from USER");
        } catch (Exception $e) {
            echo ($e);
        }

        return $users;
    }

    public final static function addUser($connection, User $user)
    {

//        $password=$userValues['user_password'];

        try {

            $userQuery = "insert into USER (name, email, password, id_user_type, fcbk_token) values ('$user->getName()' , '$user->getEmail()' , '$user->getPassword()', '$user->getUserType()', '$user->getFcbkToken()' )";
            mysqli_query($connection, $userQuery);

        } catch (Exception $e) {
            echo ($e);
        }

    }

    public final static function delUser($connection, $id)
    {

        try {

            $userQuery = "delete into USER where id = '$id'";
            mysqli_query($connection, $userQuery);

        } catch (Exception $e) {
            echo ($e);
        }

    }

}