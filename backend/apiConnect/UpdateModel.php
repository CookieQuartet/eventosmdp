<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 09/10/2014
 * Time: 10:45 PM
 */
include_once('ApiConnectConstants.php');
include_once('ApiRequest.php');
include_once('../area/SubareaQueries.php');
include_once('../event/EventQueries.php');

class UpdateModel {
    private $apiRequest;


    function __construct()
    {
        $this->apiRequest = new ApiRequest();

    }

    public function updateModel()
    {
        $this->updateAreas();
        echo("----------------------");
        $this->updateEvents();

    }

    public function updateEvents()
    {
        $jsonEventos= $this->apiRequest->getEventsByAreaJSON(2,2);

    }


    public function updateAreas()
    {

        $jsonAreas= $this->apiRequest->getAreasJSON();



        /*Obtener las areas de la base nuestra e ir recorriendo uno a uno de los resultados obtenidos de la API, si no esta lo agrego,
        y si esta (con el id que devuelve la API), implemento un compareTo y si son
         distintos reemplazo el actual por el nuevo.
        */
    }

} 