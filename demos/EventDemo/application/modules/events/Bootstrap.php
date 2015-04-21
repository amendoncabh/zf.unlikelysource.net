<?php

class Events_Bootstrap extends Zend_Application_Module_Bootstrap
{
	
	protected function _initDateEvent()
	{
		Events_Service_EventManager::
		getEventManager()->attach(
			Events_Service_EventManager::EVENTS_EVENT_DATE, 
			// array(<object instance>, 'methodName')
			function ($e) { echo 'EVENT TRIGGERED: '
								 . '<br />Event Class: ' . get_class($e) 
								 . '<br />Event Name:  ' . $e->getName()
								 . '<br />Target:      ' . get_class($e->getTarget())
								 . '<br />Method Param:' . $e->getParam('method')
								 . '<br />' . date('Y-m-d H:i:s'); });
	}

}