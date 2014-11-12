<?php
/**
 * Created by PhpStorm.
 * User: martin
 * Date: 05/10/14
 * Time: 03:04
 * El crédito es para Pablo, que medio dormido me dijo: "podríamos hacer una clase Login
 * que devuelva un usuario..."
 */
include_once('../database/DataBase.php');
include_once('./User.php');
include_once('./userAdmin/UserAdmin.php');
include_once('./userGeneral/UserGeneral.php');
include_once('./userPublisher/UserPublisher.php');
include_once('./userType/UserTypeEnum.php');

class UserFactory {
    private static $instance;
    private static $user;
    private static $loggedIn;
    private static $dataBase;

    private function __construct()
    {
        UserFactory::$dataBase = new DataBase();
        UserFactory::$loggedIn = false;
        UserFactory::$instance = $this;
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new UserFactory();
        }
        return self::$instance;
    }

    public static function getDatabase() {
        if(!self::$dataBase) {
            self::$dataBase = new DataBase();
        }
        return self::$dataBase;
    }

    private function getUserByEmail($email)
    {
        $query = "select * from `USER` WHERE email = '$email'";
        $sql = self::getDatabase()->query($query);

        if(self::getDatabase()->hasRows($sql)) {
            return self::getDatabase()->fetchAssoc($sql);
        }
        return false;
    }

    private function addUser($email, $password, $active, $id_user_type)
    {
        $query_insert = "insert into `USER` (email, name, password, active, id_user_type) values ('$email', '$email', '$password', $active, $id_user_type)";
        $query = "select * from `USER` WHERE email = '$email'";

        $insert = self::getDatabase()->query($query_insert);
        if($insert) {
            $select = self::getDatabase()->query($query);
            return $select;
        } else {
            return false;
        }
    }

    private function addFullUser($email, $name, $password, $id_user_type)
    {
        $query_insert = "insert into `USER` (email, name, password, active, id_user_type) values ('$email', '$name', '$password', '1', $id_user_type)";
        $query = "select * from `USER` WHERE email = '$email'";

        $insert = self::getDatabase()->query($query_insert);
        if($insert) {
            $select = self::getDatabase()->query($query);
            return $select;
        } else {
            return false;
        }
    }

    public static function encryptPassword($password)
    {
        // acá es donde deberíamos armar una función de encriptado de password
        // antes de mandarlo a la db
        return $password;
    }

    public function login($email, $password)
    {
        $userData = $this->getUserByEmail($email);
        if($userData && $userData['active'] == '1') {
            $encryptedPassword = UserFactory::encryptPassword($password);
            if($encryptedPassword == $userData['password']) {
                $email = $userData['email'];
                $id = $userData['id'];
                $name = $userData['name'];
                $password = $userData['password'];
                $active = $userData['active'];
                switch($userData['id_user_type']) {
                    case UserTypeEnum::UserAdminType:
                        UserFactory::$user = new UserAdmin($email, $id, $name, $password, $active);
                        break;
                    case UserTypeEnum::UserPublisherType:
                        UserFactory::$user = new UserPublisher($email, $id, $name, $password, $active);
                        break;
                    case UserTypeEnum::UserGeneralType:
                        UserFactory::$user = new UserGeneral($email, $id, $name, $password, $active);
                        break;
                }
                UserFactory::$loggedIn = true;
                return UserFactory::$user;
            } else {
                // no coinciden el password ingresado con el password registrado
                return false;
            }
        } else {
            // no se encuentra ningun usuario con el mail ingresado
            return null;
        }
    }

    public function register($email, $password, $id_user_type)
    {
        $userData = $this->getUserByEmail($email);
        if(!$userData) {
            $encryptedPassword = UserFactory::encryptPassword($password);
            $sql = $this->addUser($email, $encryptedPassword, 1, $id_user_type);
            if(self::getDatabase()->hasRows($sql)) {
                return $this->login($email, $password);
            }
            return false;

        } else {
            // ya se encuentra un usuario con el mail ingresado
            return false;
        }
    }
    public function create($email, $name, $password, $id_user_type)
    {
        $userData = $this->getUserByEmail($email);
        if(!$userData) {
            $encryptedPassword = UserFactory::encryptPassword($password);
            $sql = $this->addFullUser($email, $name, $encryptedPassword,  $id_user_type);
            if(self::getDatabase()->hasRows($sql)) {
                return true;
            }
            return false;

        } else {
            // ya se encuentra un usuario con el mail ingresado
            return false;
        }
    }

} 