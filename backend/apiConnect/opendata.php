<?php
/*
 * Esta clase actualiza la base de datos mergeando la base de Eventos y Areas de la Municipalidad
 *
 * */
include_once('UpdateModel.php');

/*Comienzo del update*/
$updateModel = new UpdateModel();
$updateModel->updateModel();