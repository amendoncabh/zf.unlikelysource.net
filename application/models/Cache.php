<?php
class Application_Model_Cache
{
    public static $cache;
	public static function getCache()
	{
	    // cache params; lifetime = 1 week (7 x 24 x 60 x 60 seconds)
	    if (!self::$cache) {
			$frontendOptions = array('lifetime' => 604800, 
									 'automatic_serialization' => true);
			$backendOptions  = array('cache_dir' => APPLICATION_PATH . '/../data/cache');
			self::$cache 	 = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
	    }
		return self::$cache;
	}
}
