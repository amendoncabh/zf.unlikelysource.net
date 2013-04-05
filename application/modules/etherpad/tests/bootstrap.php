<?php
error_reporting(E_STRICT | E_ALL);
date_default_timezone_set('Europe/Berlin');

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../..'));

define('APPLICATION_ENV', 'testing');

set_include_path(implode(PATH_SEPARATOR, array(
    APPLICATION_PATH,
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();
