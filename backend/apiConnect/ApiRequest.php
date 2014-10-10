<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 09/10/2014
 * Time: 09:42 PM
 */
include_once('ApiConnectConstants.php');

class ApiRequest {

    public function getAreas()
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

        if ($aresult->Estado=="Ok")
        {
            echo json_encode($aresult->Areas);
            return json_encode($aresult->Areas);
        }
        else
        {
            return null;
        }
    }

    public function getEventsByArea($idArea)
    {
        $url = consultaEventosUrl;
        $data = array( "Token" => defaultToken, "IdArea" => $idArea);
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

        if ($aresult->Estado=="Ok")
        {
            return json_encode($aresult->Eventos);
        }
        else
        {
            return null;
        }
    }


} 