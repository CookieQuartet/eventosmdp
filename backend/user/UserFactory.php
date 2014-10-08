<?php
/**
 * Created by PhpStorm.
 * User: martin
 * Date: 05/10/14
 * Time: 03:04
 * El crédito es para Pablo, que medio dormido me dijo: "podríamos hacer una clase Login
 * que devuelva un usuario..."
 */

class UserFactory {
    private static $instance;
    private static $user;
    private static $loggedIn;
    private $dataBase;

    private function __construct()
    {
        $this->dataBase = new DataBase();
        UserFactory::$loggedIn = false;
        UserFactory::$instance = $this;
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new UserFactory();
        }
        return self::$instance;
    }

    private function getUserByEmail($user)
    {
        $sql = $this->dataBase->query("select * from `USER` WHERE email = $user->email");
        if($this->dataBase->hasRows($sql)) {
            return $this->dataBase->fetchAssoc($sql);
        }
        return false;
    }

    private function addUser($email, $fcbkToken, $id, $name, $password, $active, $id_user_type)
    {
        $sql = $this->dataBase->query("insert into USER (email, fcbk_token, id, name, password, active, id_user_type) values ('$email', '$fcbkToken', $id, '$name', '$password', $active, $id_user_type)");
        return $this->getUserByEmail($email);
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
        if($userData) {
            $encryptedPassword = UserFactory::encryptPassword($password);
            if($encryptedPassword == $userData['password']) {
                $email = $userData['email'];
                $fcbkToken = $userData['fcbkToken'];
                $id = $userData['id'];
                $name = $userData['name'];
                $password = $userData['password'];
                $active = $userData['active'];
                switch($userData['id_user_type']) {
                    case UserTypeEnum::UserAdminType:
                        UserFactory::$user = new UserAdmin($email, $fcbkToken, $id, $name, $password, $active);
                        break;
                    case UserTypeEnum::UserPublisherType:
                        UserFactory::$user = new UserPublisher($email, $fcbkToken, $id, $name, $password, $active);
                        break;
                    case UserTypeEnum::UserGeneralType:
                        UserFactory::$user = new UserGeneral($email, $fcbkToken, $id, $name, $password, $active);
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

    public function register($email, $fcbkToken, $id, $name, $password, $active, $id_user_type)
    {
        $userData = $this->getUserByEmail($email);
        if(!$userData) {
            $encryptedPassword = UserFactory::encryptPassword($password);
            return $this->addUser($email, $fcbkToken, $id, $name, $encryptedPassword, $active, $id_user_type);
        } else {
            // ya se encuentra un usuario con el mail ingresado
            return false;
        }
    }

    public static function logout()
    {
        self::$loggedIn = false;
        self::$user = null;
    }

    public static function loggedIn()
    {
        return self::$loggedIn;
    }

    public static function user()
    {
        if(self::$loggedIn) {
            return self::$user;
        } else {
            return null;
        }
    }
} 