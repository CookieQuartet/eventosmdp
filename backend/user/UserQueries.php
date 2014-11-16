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

    public function fetch_all($rows) {
        return $this->dataBase->fetch_all($rows);
    }

    public final function getUserList() //Lista de Usuarios
    {
        //$userQuery = "select UR.*,UT.description from USER UR, USER_TYPE UT where UR.id_user_type = UT.id";
        $userQuery = "select UR.*,UT.description from USER UR join USER_TYPE UT on UR.id_user_type = UT.id";
        //$userQuery = "select * from USER";
        return $this->dataBase->query($userQuery);
    }

    public final function getEventList() //Lista de Usuarios
    {
        //$userQuery = "select UR.*,UT.description from USER UR, USER_TYPE UT where UR.id_user_type = UT.id";
        $query = "SELECT `Altura`, `Calle`, `DescripcionCalendario`, `DescripcionEvento`, `Destacado`, `DetalleTexto`, `DireccionEvento`, `FechaHoraFin`, `FechaHoraInicio`, `Frecuencia`, `IdArea`, `IdCalendario`, `IdEvento`, `IdSubarea`, `Latitud`, `Longitud`, `Lugar`, `NombreArea`, `NombreCalendario`, `NombreEvento`, `NombreSubAreaFormat`, `NombreSubarea`, `Precio`, `Repetir`, `RutaImagen`, `RutaImagenMiniatura`, `TodoDia`, `ZonaHoraria` FROM `EVENT_API` limit 28";
        //$query = "select UR.*,UT.description from USER UR join USER_TYPE UT on UR.id_user_type = UT.id";
        //$userQuery = "select * from USER";
        return $this->dataBase->query($query);
    }

    /*public final function addUser($user)
    {
        $userQuery = "insert into USER (name, email, password, id_user_type) values ('$user->getName()' , '$user->getEmail()' , '$user->getPassword()', '$user->getUserType()' )";
        return $this->dataBase->query($userQuery);
    }*/

    //public final function updateUser($user)
    public final function updateUser($email, $id, $name, $password, $active, $type)
    {
        //$userQuery = "update USER set 'name'='$user->getName()', 'email'='$user->getEmail()', 'password'='$user->getPassword()', 'id_user_type'='$user->getUserType()', 'active'='$user->getActive()' where 'id'='$user->getId()'";
        $_active = $active == '1' ? true :  false;
        $userQuery = "update USER set name='$name', email='$email', password='$password', id_user_type=$type, active=$_active where id=$id";
        echo($userQuery);
        return $this->dataBase->query($userQuery);
    }

    public final function toggleUser($id, $status)
    {
        $userQuery = "update USER set active = '$status' where id = '$id'";
        return $this->dataBase->query($userQuery);
    }

    public final function getUserByEmail($email)
    {
        $userQuery = "select UR.*,UT.description from USER UR, USER_TYPE UT where UR.email = '$email' and UR.id_user_type = UT.id";
        return $this->dataBase->query($userQuery);
    }

    public final function getUserById($id)
    {
        $userQuery = "select UR.*,UT.description from USER UR, USER_TYPE UT where UR.id = $id and UR.id_user_type = UT.id";
        return $this->dataBase->query($userQuery);
    }

}