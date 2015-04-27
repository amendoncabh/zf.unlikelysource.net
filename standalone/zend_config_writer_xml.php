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
require_once 'Zend/Config/Writer/Json.php';

$config = new Zend_Config_Ini('application.ini');
$writer1 = new Zend_Config_Writer_Json(array('config' => $config));
echo $writer1->render();
$writer2 = new Zend_Config_Writer_Xml(array('config' => $config));
echo $writer2->render();
