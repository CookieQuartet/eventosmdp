<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 07:49 PM
 */
require_once ('DataBaseConstants.php');

class DataBase {
    public final static function getDataBaseConnection() //Obtener la BD
    {

        try {

            $connection=mysqli_connect("p:".host,user,password,database); //Host, usuario, password, base de datos

        } catch (Exception $e) {
            echo ($e);
        }

        return $connection;
    }

    public final static function closeDataBase($connection) //Cerrar la BD
    {
        mysqli_close($connection);
    }

} 