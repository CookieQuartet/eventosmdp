<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */

include_once('EventQueries.php');

class EventController {

    private $eventQueries;

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
                        $from = isset($_GET['from'])? $_GET['from']:null;
                        $to = isset($_GET['to'])? $_GET['to']:null;
                        $return = $this->getEvents($from, $to);
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

    public function getEvents($from, $to)
    {
        $rows = $this->eventQueries->getEvents($from, $to);
        $result = $rows->fetch_all(MYSQLI_ASSOC);

        return json_encode($result);
        /*$json_array = array();
        $length = count($result);
        $i = 0;

        while($i < $length) {
            array_push($json_array, json_encode($result[$i]));
            $i++;
        }
        $rows->free();
        return '['.implode(',', $json_array).']';*/
    }

    public function newEvent()
    {

    }

    public function updateEvent()
    {

    }
}