<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:27 PM
 */

include_once('../database/DataBase.php');

class UserQueries {

    private $dataBase;

    function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public final function getUserList() //Lista de Usuarios
    {
        //$userQuery = "select UR.*,UT.description from USER UR, USER_TYPE UT where UR.id_user_type = UT.id";
        $userQuery = "select UR.*,UT.description from USER UR join USER_TYPE UT on UR.id_user_type = UT.id";
        //$userQuery = "select * from USER";
        return $this->dataBase->query($userQuery);
    }

    public final function addUser($user)
    {
        $userQuery = "insert into USER (name, email, password, id_user_type) values ('$user->getName()' , '$user->getEmail()' , '$user->getPassword()', '$user->getUserType()' )";
        return $this->dataBase->query($userQuery);
    }

    public final function updateUser($user)
    {
        $userQuery = "update USER set 'name'='$user->getName()', 'email'='$user->getEmail()', 'password'='$user->getPassword()', 'id_user_type'='$user->getUserType()', 'active'='$user->getActive()' where 'id'='$user->getId()'";
        return $this->dataBase->query($userQuery);
    }

    public final function deleteUser($user)
    {
        $userQuery = "update USER set active = '0' where id = '$user->id'";
        return $this->dataBase->query($userQuery);
    }

    public final function getUserById($id)
    {
        $userQuery = "select UR.*,UT.description from USER UR, USER_TYPE UT where UR.id = $id and UR.id_user_type = UT.id";
        return $this->dataBase->query($userQuery);
    }

}