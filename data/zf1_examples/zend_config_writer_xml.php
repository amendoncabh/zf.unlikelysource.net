<?php
/*
 * application.ini file:
[production]
phpSettings.display_startup_errors = 0
phpSettings.display_errors = 0
includePaths.library = APPLICATION_PATH "/../library"
bootstrap.path = APPLICATION_PATH "/Bootstrap.php"
bootstrap.class = "Bootstrap"
appnamespace = "Application"
resources.frontController.controllerDirectory = APPLICATION_PATH "/controllers"
resources.frontController.params.displayExceptions = 0

[staging : production]

[testing : production]
phpSettings.display_startup_errors = 1
phpSettings.display_errors = 1

[development : production]
phpSettings.display_startup_errors = 1
phpSettings.display_errors = 1
resources.frontController.params.displayExceptions = 1

 */
require_once 'Zend/Config/Ini.php';
require_once 'Zend/Config/Writer/Xml.php';

$config = new Zend_Config_Ini('application.ini');
$writer = new Zend_Config_Writer_Xml(array('config' => $config));
header('Content-Type: text/xml');
echo $writer->render();
