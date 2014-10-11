<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/10/2014
 * Time: 05:27 PM
 */
//include_once('../User.php');

class UserAdmin extends User {

    function __construct($email, $id, $name, $password, $active)
    {
        parent::__construct($email, $id, $name, $password, $active);
        $this->userType= UserTypeEnum::UserAdminType;
    }
}

