<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 07:49 PM
 */
require_once ('DataBaseConstants.php');

class DataBase {

    private $connection;

    public function openConnection() //Obtener la BD
    {

        try {

            $this->connection =mysqli_connect(host,user,password,database); //Host, usuario, password, base de datos

        } catch (Exception $e) {
            return ($e);
        }
    }

    public function closeConnection()
    {
        try {

            mysqli_close($this->connection);

        } catch (Exception $e) {
            return ($e);
        }
    }

    public function query($query)
    {
        $query = str_replace("}", "", $query);

        try
        {
            if(empty($this->connection))
            {
                $this->openConnection();

                $queryResult = mysqli_query($this->connection, $query);

                $this->closeConnection();

            }
            else
            {
                $queryResult = mysqli_query($this->connection, $query);
            }

            return $queryResult;
        }
        catch(exception $e)
        {
            return $e;
        }
    }


} 