<?php

    include_once('ApiConnectConstants.php');

    //$url = "http://appsb.mardelplata.gob.ar/consultas/wsCalendario/RESTServiceCalendario.svc/calendario/consultaEventos";
/*    $data = array(
        "Token" => defaultToken,
        "IdArea" => idAreaCultura,
        "IdSubarea" => 2,
        "Palabra" => null,
        //"FechaDesde" => "20141028T000000",
        //"FechaHasta" => "20141030T000000"
        //"FechaDesde" => null,
        //"FechaHasta" => null

        "FechaDesde" => $_GET['from'],
        "FechaHasta" => $_GET['to']

        //"FechaDesde" => "20131128T000000",
        //"FechaHasta" => "20161030T000000"



        //"FechaHasta" => null
    );
    $data_string = json_encode($data);


    $ch = curl_init(consultaEventosUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);

    $aresult = json_decode($result)->Eventos;

    //$aresult = json_decode($result);


    echo(json_encode($aresult));
*/


function getEventos() {
    $url = consultaEventosUrl;
    $data = array(
        "Token" => defaultToken,
        "IdArea" => 2,
        "IdSubarea" => 2,
        "Palabra" => null,
        //"FechaDesde" => "20131028T000000",
        //"FechaHasta" => "20141030T000000"
        //"FechaDesde" => null,
        //"FechaHasta" => null

        "FechaDesde" => $_GET['from'],
        "FechaHasta" => $_GET['to']

        //"FechaDesde" => "20131128T000000",
        //"FechaHasta" => "20161030T000000"

        //"FechaHasta" => null
    );
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

    $aresult = json_decode($result)->Eventos;

    echo(json_encode($aresult));

}

function getSubareas() {
    $url = consultaAreasUrl;
    $data = array( "Token" => defaultToken, "IdArea" => 2);
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

    echo(json_encode($aresult));

}


getEventos();
//getSubareas();