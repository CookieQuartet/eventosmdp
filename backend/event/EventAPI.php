<?php

//header('Content-type: application/json; charset=ISO-8859-1');
header('Content-type: application/json; charset=UTF-8');

include_once('EventController.php');

$controller = new EventController();

$controller->invoke();