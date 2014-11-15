<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */
include('Event.php');

class EventController {

    public function invoke()
    {
        $return = "";
        if (!isset($_GET['method']))
        {
            $return = '{ "error": "No se envió un método" }';
        } else {
            switch($_GET['method'])
            {
                case 'get_events':
                    $fechaDesde = isset($_GET['from'])?$_GET['from']:null;
                    $fechaHasta = isset($_GET['to'])?$_GET['to']:null;

                    $return = getEvents($fechaDesde, $fechaHasta);

                    break;
                case 'get_reviews':

                    break;
                case 'add_review':

                    break;
                case 'remove_favorite':

                    break;
                case 'add_favorite':

                    break;

            }
        }
        echo $return;
    }

    public function getEvents($fechaDesde, $fechaHasta)
    {
        $ownEvents= Event::getEventQueries()->getOwnEventsList();
        if ($ownEvents==null)
        {
            $ownEvents = array();
        }

        $apiEvents = Event::getEventQueries()->getApiEventsList();
        echo json_encode($apiEvents);

        if ($apiEvents==null)
        {
            $apiEvents = array();
        }
        echo json_encode($apiEvents);
//        foreach (array_merge($ownEvents,$apiEvents) as $e)
//        {
//            echo $e["Calle"];
//            echo ("</br>");
//        }
//        die;

        $pepe=array_merge($ownEvents,$apiEvents);
        echo (json_encode($apiEvents)); die;

    }

    public function newEvent()
    {

    }

    public function updateEvent()
    {

    }



}

$pepe = new EventController();

$pepe->getEvents(null,null);