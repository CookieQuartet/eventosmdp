<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:27 PM
 */

class UserGeneral  extends  User {

    function __construct($email, $fcbkToken, $id, $name, $password)
    {
        parent::__construct($email, $fcbkToken, $id, $name, $password);
        $this->userType= $this->getUserType();
    }

    public function getUserType()
    {
        return (UserTypeEnum::UserGeneralType);
    }
} 