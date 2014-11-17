<?php

include_once('../user/User.php');
include_once('../user/userAdmin/UserAdmin.php');
include_once('../user/userGeneral/UserGeneral.php');
include_once('../user/userPublisher/UserPublisher.php');
include_once('../user/userType/UserTypeEnum.php');
include_once('../user/UserFactory.php');

session_start();

include_once('CommentController.php');

$controller = new CommentController();

$controller->invoke();