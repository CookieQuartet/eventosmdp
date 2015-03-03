<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 09/10/2014
 * Time: 09:42 PM
 */
include_once('ApiConnectConstants.php');
//include_once('../lib/underscore.php');

class ApiRequest {

    private $dataBase;

    function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public function getSubareas()
    {
        $url = consultaAreasUrl;
        $data = array( "Token" => defaultToken, "IdArea" => idAreaCultura);
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
        $aresult = json_decode(utf8_encode($result));

        if ($aresult->Estado==sucessfull || $aresult->Estado==warning)
        {
            return $aresult->Areas[0]->Subareas;
        }
        else
        {
            return null;
        }

    }

    public function getEventsBySubarea($idSubArea, $fechaDesde)
    {
        $url = consultaEventosUrl;
        $data = array( "Token" => defaultToken, "IdArea" => idAreaCultura, "IdSubarea" => $idSubArea, "Palabra" => null, "FechaDesde" => $fechaDesde, "FechaHasta" => null);
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
        //$aresult = json_decode(utf8_encode($result));
        //$aresult = json_decode(iconv( "ISO-8859-1", "UTF-8", $result ));


        var_dump($aresult);

        if ($aresult->Estado==warning)
        {
           // return $aresult->Eventos;
            return array_map("unserialize", array_unique(array_map("serialize",array_merge ($aresult->Eventos,$this->getEventsBySubarea($idSubArea, end($aresult->Eventos)->FechaHoraInicio)))));
        }
        elseif ($aresult->Estado==sucessfull)
        {
            return $aresult->Eventos;
        }
        else //Error
        {
            return array();
        }
    }


} 