<?php
require 'Zend/Config/Ini.php';
require 'Zend/Config/Xml.php';
require 'Zend/Debug.php';
// NOTE: to allow the merge to work, allowModifications flag must be set TRUE
$config1 = new Zend_Config_Ini('/var/www/php_zff/config.ini','staging',array('allowModifications' => TRUE));
$config2 = new Zend_Config_Ini('/var/www/php_zff/config.ini','other');
Zend_Debug::dump($config1->toArray(),'*** STAGING ***');
Zend_Debug::dump($config2->toArray(),'*** OTHER ***');
$config1->merge($config2);
Zend_Debug::dump($config1->toArray(),'*** MERGED ***');
// NOTE: if you want all params, and not specific sections, don't specify the 2nd parameter
$config = new Zend_Config_Ini('/var/www/php_zff/config.ini');
Zend_Debug::dump($config->toArray(),'*** ALL SECTIONS ***');
?>
