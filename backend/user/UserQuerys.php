<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:27 PM
 */

include('../database/DataBase.php');


class UserQuerys {

    private $dataBase;

    function __construct()
    {
        $this->$dataBase = new DataBase();
    }

    public final function getUserList() //Lista de Usuarios
    {
        return $this->$dataBase->query("select * from USER");
    }

    public final function addUser(User $user)
    {
        return $this->$dataBase->query("insert into USER (name, email, password, id_user_type, fcbk_token) values ('$user->getName()' , '$user->getEmail()' , '$user->getPassword()', '$user->getUserType()', '$user->getFcbkToken()' )");
    }

    public final function updateUser(User $user)
    {
        return $this->$dataBase->query("update USER set 'name'=$user->getName(), 'email'=$user->getEmail(), 'password'=$user->getPassword(), 'id_user_type'=$user->getUserType(), 'fcbk_token'=$user->getFcbkToken(), 'active'=$user->getActive() where 'id'=$user->getId()");
    }

    public final function deleteUser($id)
    {
        return $this->$dataBase->query("update USER set active = '0' where id = '$id'");
    }

    public final function getUserById($id)
    {
        return $this->$dataBase->query("select * from `USER` WHERE id = $id");
    }

}