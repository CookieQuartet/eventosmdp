<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:27 PM
 */

include('DataBase.php');


class UserQuerys {

    public final static function getUserList() //Lista de Usuarios
    {
        $dataBase = new DataBase();
        return $dataBase->query("select * from USER");
    }

    public final static function addUser(User $user)
    {
        $dataBase = new DataBase();
        return $dataBase->query("insert into USER (name, email, password, id_user_type, fcbk_token) values ('$user->getName()' , '$user->getEmail()' , '$user->getPassword()', '$user->getUserType()', '$user->getFcbkToken()' )");
    }

    public final static function updateUser($connection, User $user)
    {
        $dataBase = new DataBase();
        return $dataBase->query("update USER set 'name'=$user->getName(), 'email'=$user->getEmail(), 'password'=$user->getPassword(), 'id_user_type'=$user->getUserType(), 'fcbk_token'=$user->getFcbkToken(), 'active'=$user->getActive() where 'id'=$user->getId()");
    }

    public final static function deleteUser($id)
    {
        $dataBase = new DataBase();
        return $dataBase->query("update USER set active = '0' where id = '$id'");
    }

    public final static function getUserById($connection, $id)
    {

            $user = $connection->query("select * from `USER` WHERE id = $id");

    }

}