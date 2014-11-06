<?php
/**
 * Created by PhpStorm.
 * User: Julián
 * Date: 04/10/2014
 * Time: 05:30 PM
 */
include('Event.php');

class EventController {

    public function showEvents()
    {
        $ownEvents = array();
        $apiEvents = array();
        $ownEvents= Event::getEventQueries()->getOwnEventsList();
        $apiEvents = Event::getEventQueries()->getApiEventsList();

        echo json_encode(array_merge($ownEvents,$apiEvents)); die;

    }

    public function newEvent()
    {

    }

    public function updateEvent()
    {

    }



}

$pepe = new EventController();

$pepe->showEvents();