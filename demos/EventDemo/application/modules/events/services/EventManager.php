<?php

class Events_Service_EventManager
{
	
	const EVENTS_MANAGER_NAME = 'events.eventmanager';
	const EVENTS_EVENT_DATE   = 'events.date';	
	
	protected static $em;
		
	public static function getEventManager()
	{
		if (!self::$em) { 
			self::$em = new Zend_EventManager_EventManager(static::EVENTS_MANAGER_NAME);
		}
		return self::$em;
	}

}