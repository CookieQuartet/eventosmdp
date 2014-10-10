<?php
$url = "http://appsb.mardelplata.gob.ar/consultas/wsCalendario/RESTServiceCalendario.svc/calendario/consultaAreas";
$data = array( "Token" => "01234567890123456789012345678901");
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
$aresult = json_decode($result);

//var_dump($aresult->Areas);
if ($aresult->Estado=="Ok") {
    echo json_encode($aresult->Areas);

}