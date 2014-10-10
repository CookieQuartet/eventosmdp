<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 07:49 PM
 */
include_once('DataBaseConstants.php');

class DataBase {

    private $connection;

    private function openConnection() //Obtener la BD
    {

        try {
            $this->$connection =mysqli_connect(host,user,password,database); //Host, usuario, password, base de datos
            return true;

        } catch (Exception $e) {
            return ($e);
        }
    }

    private function closeConnection()
    {
        try {

            mysqli_close($this->$connection);
            return true;

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

    public function hasRows($result)
    {
        try
        {
            if(mysqli_num_rows($result)>0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(exception $e)
        {
            return $e;
        }
    }

    public function countRows($result)
    {
        try
        {
            return mysqli_num_rows($result);
        }
        catch(exception $e)
        {
            return $e;
        }
    }

    public function fetchAssoc($result)
    {
        try
        {
            return mysqli_fetch_assoc($result);
        }
        catch(exception $e)
        {
            return $e;
        }
    }

    public function fetchArray($result)
    {
        try
        {
            return mysqli_fetch_array($result);
        }
        catch(exception $e)
        {
            return $e;
        }
    }

} 