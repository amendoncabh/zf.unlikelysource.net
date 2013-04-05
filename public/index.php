<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

//ini_set('display_errors', 1);
//define(APPLICATION_ENV, 'development');

/** Zend_Application */
require_once 'Zend/Application.php';
require_once APPLICATION_PATH . '/models/Cache.php';
require_once 'Zend/Config/Ini.php';
require_once 'Zend/Cache.php';

// config cache params
if (APPLICATION_ENV == 'production') {
	$options['cache']['dir']  = APPLICATION_PATH  . '/../data/cache';
	$options['cache']['life'] = 3600;
	// check for config cache
	$cache = Application_Model_Cache::getCache($options);
	$config = $cache->load('config');
	if (!$config) {
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
		$cache->save($config, 'config');
	}
} else {
    $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
}

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    $config
);
$application->bootstrap()
            ->run();
