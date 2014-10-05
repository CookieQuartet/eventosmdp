<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:27 PM
 */

include('../database/DataBase.php');
//require('../user/User.php');

class UserQueries {

    private $dataBase;
    private $user;

    function __construct($user)
    {
        $this->dataBase = new DataBase();
        $this->user = $user;
    }

    public final function getUserList() //Lista de Usuarios
    {
        return $this->dataBase->query("select * from USER");
    }

    public final function addUser()
    {
        return $this->dataBase->query("insert into USER (name, email, password, id_user_type, fcbk_token) values ('$this->user->getName()' , '$this->user->getEmail()' , '$this->user->getPassword()', '$this->user->getUserType()', '$this->user->getFcbkToken()' )");
    }

    public final function updateUser()
    {
        $query = "update USER set 'name'='$this->user->getName()', 'email'='$this->user->getEmail()', 'password'='$this->user->getPassword()', 'id_user_type'='$this->user->getUserType()', 'fcbk_token'='$this->user->getFcbkToken()', 'active'='$this->user->getActive()' where 'id'='$this->user->getId()'";
        return $this->dataBase->query($query);
    }

    public final function deleteUser()
    {
        return $this->dataBase->query("update USER set active = '0' where id = '$this->user->id'");
    }

    public final function getUserById()
    {
        return $this->dataBase->query("select * from `USER` WHERE id = $this->user->id");
    }

}