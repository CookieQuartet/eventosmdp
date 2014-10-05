<?php
/**
 * Created by PhpStorm.
 * User: martin
 * Date: 05/10/14
 * Time: 03:04
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
        if(!UserFactory::$instance) {
            UserFactory::$instance = new UserFactory();
        }
        return UserFactory::$instance;
    }

    private function getUserByEmail($user)
    {
        $sql = $this->dataBase->query("select * from `USER` WHERE email = $user->email");
        if($this->dataBase->hasRows($sql)) {
            return $this->dataBase->fetchAssoc($sql);
        }
        return false;
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
            $encryptedPassword = $this->encryptPassword($password);
            if($encryptedPassword == $userData['password']) {
                $email = $userData['email'];
                $fcbkToken = $userData['fcbkToken'];
                $id = $userData['id'];
                $name = $userData['name'];
                $password = $userData['password'];
                $active = $userData['active'];
                switch($userData['password']) {
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

    public function logout()
    {
        UserFactory::$loggedIn = false;
        UserFactory::$user = null;
    }

    public static function loggedIn()
    {
        return UserFactory::$loggedIn;
    }

    public static function user()
    {
        if(UserFactory::$loggedIn) {
            return UserFactory::$user;
        } else {
            return null;
        }
    }
} 