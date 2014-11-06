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
        $ownEvents= Event::getEventQueries()->getOwnEventsList();
        if ($ownEvents==null)
        {
            $ownEvents = array();
        }

        $apiEvents = Event::getEventQueries()->getApiEventsList();
        if ($apiEvents==null)
        {
            $apiEvents = array();
        }

        return json_encode(array_merge($ownEvents,$apiEvents));

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