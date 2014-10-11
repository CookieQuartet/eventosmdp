<?php

include_once('./User.php');
include_once('./userAdmin/UserAdmin.php');
include_once('./userGeneral/UserGeneral.php');
include_once('./userPublisher/UserPublisher.php');
include_once('./userType/UserTypeEnum.php');
include_once('./UserFactory.php');

session_start();

include_once('./UserController.php');

if(!isset($_SESSION["userFactory"])) {
    $_SESSION["userFactory"] = UserFactory::getInstance();
}

$controller = new UserController($_SESSION["userFactory"]);

$controller->invoke();