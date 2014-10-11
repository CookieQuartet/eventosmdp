<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:26 PM
 */
include_once('./UserQueries.php');


abstract class User {
    private $id;
    private $name;
    private $email;
    private $password;
    protected $userType;
    private $active; //Si esta en True el usuario esta habilitado
    private static $userQueries;

    function __construct($email, $id,$name, $password, $active)
    {
        $this->email = $email;
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->active = $active;
    }

    public static function getUserQueries() {
        if (!isset(self::$userQueries)) {
            self::$userQueries = new UserQueries();
        }
        return self::$userQueries;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public function getUserData()
    {
        return array(
            "id" => $this->id,
            "name" => $this->name,
            "type" => $this->userType,
            "email" => $this->email,
            "logged" => true
        );
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFcbkToken()
    {
        return $this->fcbkToken;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = UserFactory::encryptPassword($password);
    }

    private function clearUser()
    {
        $this->email = '';
        $this->id = '';
        $this->name = '';
        $this->password = '';
        $this->active = 0;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

} 