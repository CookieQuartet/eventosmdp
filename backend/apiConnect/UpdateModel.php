<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 09/10/2014
 * Time: 10:45 PM
 */
include_once('ApiConnectConstants.php');
include_once('ApiRequest.php');
include_once('../area/AreaQueries.php');
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
        // this.updateEvents();

    }

    public function updateEvents()
    {

    }


    public function updateAreas()
    {

        $jsonAreas= $this->apiRequest->getAreas();

        /*Obtener las areas de la base nuestra e ir recorriendo uno a uno de los resultados obtenidos de la API, si no esta lo agrego,
        y si esta (con el id que devuelve la API), implemento un compareTo y si son
         distintos reemplazo el actual por el nuevo.
        */
    }

} 