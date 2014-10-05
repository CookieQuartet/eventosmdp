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

    public final static function updateUser($connection, User $user)
    {
        try {

            $commentQuery = "update USER set 'name'=$user->getName(), 'email'=$user->getEmail(), 'password'=$user->getPassword(), 'id_user_type'=$user->getUserType(), 'fcbk_token'=$user->getFcbkToken(), 'active'=$user->getActive() where 'id'=$user->getId()";
            mysqli_query($connection, $commentQuery);

        } catch (Exception $e) {
            echo ($e);
        }
    }

    public final static function deleteUser($connection, $id)
    {

        try {

            $userQuery = "update USER set active = '0' where id = '$id'";
            mysqli_query($connection, $userQuery);

        } catch (Exception $e) {
            echo ($e);
        }

    }

    public final static function getUserById($connection, $id)
    {

        try {
            $user = $connection->query("select * from `USER` WHERE id = $id");
        } catch (Exception $e) {
            echo($e);
        }

        return $user;
    }

}