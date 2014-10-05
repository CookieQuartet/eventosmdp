<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:26 PM
 */

abstract class User {
    private $id;
    private $name;
    private $email;
    private $password;
    protected $userType;
    private $active; //Si esta en True el usuario esta habilitado
    private $fcbkToken;

    function __construct($email, $fcbkToken, $id,$name, $password, $active)
    {
        $this->email = $email;
        $this->fcbkToken = $fcbkToken;
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->active = $active;
    }

    abstract public function getUserType();

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
     * @param mixed $fcbkToken
     */
    public function setFcbkToken($fcbkToken)
    {
        $this->fcbkToken = $fcbkToken;
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
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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