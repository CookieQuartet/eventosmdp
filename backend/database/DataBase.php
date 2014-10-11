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
            $this->connection = new mysqli(host, user, password, database);
            if ($this->connection->connect_errno) {
                printf("Falló la conexión: %s\n", $this->connection->connect_error);
                exit();
            }
            return true;
        } catch (Exception $e) {
            return ($e);
        }
    }

    private function closeConnection()
    {
        try {
            $this->connection->close();
            return true;
        } catch (Exception $e) {
            return ($e);
        }
    }

    public function query($query)
    {
        $query = str_replace("}", "", $query);
        try {
            if(empty($this->connection)) {
                $this->openConnection();
                $queryResult = $this->connection->query($query);
                $this->closeConnection();
            } else {
                $queryResult = $this->connection->query($query);
            }
            return $queryResult;
        } catch(exception $e) {
            return $e;
        }
    }

    public function hasRows($result)
    {
        try {
            if($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        } catch(exception $e) {
            return $e;
        }
    }

    public function countRows($result)
    {
        try {
            return $result->num_rows;
        } catch(exception $e) {
            return $e;
        }
    }

    public function fetchAssoc($result)
    {
        try {
            return mysqli_fetch_assoc($result);
        } catch(exception $e) {
            return $e;
        }
    }

    public function fetchArray($result)
    {
        try {
            return mysqli_fetch_array($result);
        } catch(exception $e) {
            return $e;
        }
    }
}