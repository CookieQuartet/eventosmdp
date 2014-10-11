<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 09/10/2014
 * Time: 09:42 PM
 */
include_once('ApiConnectConstants.php');

class ApiRequest {

    public function getAreasJSON()
    {
        $url = consultaAreasUrl;
        $data = array( "Token" => defaultToken);
        $data_string = json_encode($data);

        $request = curl_init($url);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($request, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($request);
        $aresult = json_decode($result);

        if ($aresult->Estado=="Ok" || $aresult->Estado=="Advertencia")
        {
            echo json_encode($aresult);
            return json_encode($aresult->Areas);
        }
        else
        {
            return null;
        }
    }

    public function getEventsByAreaJSON($idArea, $idSubArea)
    {
        $url = consultaEventosUrl;
        $data = array( "Token" => defaultToken, "IdArea" => $idArea, "IdSubarea" => $idSubArea, "Palabra" => null, "FechaDesde" => null, "FechaHasta" => null);
        $data_string = json_encode($data);

        $request = curl_init($url);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($request, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($request);
        $aresult = json_decode($result);

        if ($aresult->Estado=="Ok" || $aresult->Estado=="Advertencia")
        {
            echo json_encode($aresult);
            return json_encode($aresult->Eventos);
        }
        else
        {
            return null;
        }
    }


} 