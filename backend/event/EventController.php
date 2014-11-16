<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */
include('Event.php');

class EventController {

    private $event;

    function __construct()
    {
        $this->eventQueries = new EventQueries();
    }

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
                    $return = $this->getEvents(null, null);
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
        //echo 'wtf';
    }

    public function getEvents($fechaDesde, $fechaHasta)
    {
        $rows = $this->eventQueries->getApiEventList();
        $result = $rows->fetch_all(MYSQLI_ASSOC);
        $json_array = array();
        $length = count($result);
        $i = 0;

        while($i < $length) {
            $row = json_encode($result[$i]);
            if(strlen($row) > 0) {
                array_push($json_array, $row);
            }
            $i++;
        }
        $rows->free();
        return '['.implode(',', $json_array).']';
    }

    public function newEvent()
    {

    }

    public function updateEvent()
    {

    }



}
