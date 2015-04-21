<?php

class Events_TestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        Events_Service_EventManager::
        	getEventManager()->trigger(
        		Events_Service_EventManager::EVENTS_EVENT_DATE,
        		$this,
        		array('method' => __METHOD__));
    }


}

