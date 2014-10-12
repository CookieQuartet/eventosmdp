<?php
    $url = "http://appsb.mardelplata.gob.ar/consultas/wsCalendario/RESTServiceCalendario.svc/calendario/consultaEventos";
    $data = array(
        "Token" => "3C37175138FF30B0B7849684A4AC8335",
        "IdArea" => 2,
        "IdSubarea" => 2,
        "Palabra" => null,
        //"FechaDesde" => "20141028T000000",
        //"FechaHasta" => "20141030T000000"
        //"FechaDesde" => null,
        //"FechaHasta" => null

        "FechaDesde" => $_GET['from'],
        "FechaHasta" => $_GET['to']
    );
    $data_string = json_encode($data);


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);

    $aresult = json_decode($result)->Eventos;

    echo(json_encode($aresult));

