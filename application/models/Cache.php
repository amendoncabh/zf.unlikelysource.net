<?php
class Application_Model_Cache
{
    public static $cache;
	public static function getCache($config = FALSE)
	{
	    if (!self::$cache) {
	    	if (!$config) {
				$config	= Zend_Registry::get('options');
			}
			$frontendOptions = array('lifetime' => $config['cache']['life'], 'automatic_serialization' => true);
			$backendOptions  = array('cache_dir' => $config['cache']['dir']);
			self::$cache 	 = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
	    }
		return self::$cache;
	}
}
