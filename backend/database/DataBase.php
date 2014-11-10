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
            $this->openConnection();
            $queryResult = $this->connection->query($query);
            if (!$queryResult) {
                printf("Errormessage: %s\n", $this->connection->error);
            }

            $this->closeConnection();

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

    public function insertArrayObjects($table, $arrayObjects, $limit = null) {

        try {
            $this->openConnection();

            $columns = implode(", ", array_keys(get_object_vars($arrayObjects[0])));

            function getValueString($object)
            {
                $arrayObject=get_object_vars($object);
                $arrayObject = array_map('mysql_real_escape_string', $arrayObject); //VER LA CODIFICACIóN
                foreach ($arrayObject as $key => $value)
                {
                    $arrayObject[$key]="'".$value."'";
                }

                return "(".implode(", ", array_values($arrayObject))."), ";
            }

            $arrayValues = array_map('getValueString', array_values($arrayObjects));

            if ($limit!=null)
            {
                while (!empty($arrayValues))
                {
                    $arrayLimitValues = array_slice($arrayValues, 0, $limit);
                    $arrayValues =   array_slice($arrayValues, $limit);
//                    echo(count($arrayLimitValues));

                    $lastValue = substr(end($arrayLimitValues), 0, -2); /*Elimino los ultimos dos digitos del ultimo registro*/
                    $arrayLimitValues[key($arrayLimitValues)]=$lastValue;

                    $values=implode("",$arrayLimitValues); /* Lo convierto a un string*/

                    $sql = "INSERT INTO "."`".$table."` "."($columns) VALUES $values";
//                    echo($sql);
//                    echo("</br>");
//                    echo("---------");

                    //die;
                    $queryResult = $this->connection->query($sql);
                    if (!$queryResult) {
                        printf("Errormessage: %s\n", $this->connection->error);
                        continue;
                    }
                }
            }
            else
            {
                $lastValue = substr(end($arrayValues), 0, -2); /*Elimino los ultimos dos digitos del ultimo registro*/
                $arrayValues[key($arrayValues)]=$lastValue;

                $values=implode("",$arrayValues);

                $sql = "INSERT INTO "."`".$table."` "."($columns) VALUES $values";
                //            echo($sql); die;
                $queryResult = $this->connection->query($sql);
                if (!$queryResult) {
                    printf("Errormessage: %s\n", $this->connection->error);
                }
            }

            $this->closeConnection();

            return $queryResult;

        } catch(exception $e) {
            return $e;
        }
    }



}