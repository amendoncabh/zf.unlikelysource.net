<?php
// NOTE: Must be running Firefox w/ Firebug + FirePHP installed
require "Zend/Log.php";
require "Zend/Log/Writer/Stream.php";
require "Zend/Log/Writer/Firebug.php";
require "Zend/Controller/Request/Http.php";
require "Zend/Controller/Response/Http.php";

// define constants
date_default_timezone_set('Europe/London');
define('SPECIAL', 8);
define('TEST', 2);

// remove test1.log
if (file_exists('test1.log')) {
	unlink('test1.log');
}

// Set up log and 2 writers
try {
	$logger = new Zend_Log();
	$writer1 = new Zend_Log_Writer_Stream('php://output');
	$writer2 = new Zend_Log_Writer_Firebug();
	$logger->addWriter($writer1);
	$logger->addWriter($writer2);
	// Add filter to #2
	$filter = new Zend_Log_Filter_Priority(Zend_Log::CRIT);
	$writer2->addFilter($filter);
	// Assign formatter to writer
	$format = new Zend_Log_Formatter_Simple('<br />%priorityName% : %priority% : %timestamp% : %message%');
	$writer1->setFormatter($format);
	// set up Firebug output channel
	$request = new Zend_Controller_Request_Http();
	$response = new Zend_Controller_Response_Http();
	$channel = Zend_Wildfire_Channel_HttpHeaders::getInstance();
	$channel->setRequest($request);
	$channel->setResponse($response);
	// Start output buffering
	ob_start();	
	// Log some messages
	$logger->log("*******DEBUG MESSAGE********",Zend_Log::DEBUG);
	$logger->log("*******INFO MESSAGE********",Zend_Log::INFO);
	$logger->log("*******NOTICE MESSAGE********",Zend_Log::NOTICE);
	$logger->log("*******WARNING MESSAGE********",Zend_Log::WARN);
	$logger->log("*******ERROR MESSAGE********",Zend_Log::ERR);
	$logger->log("*******CRITICAL MESSAGE********",Zend_Log::CRIT);
	$logger->log("*******ALERT MESSAGE********",Zend_Log::ALERT);
	$logger->log("*****EMERGENCY MESSAGE*****",Zend_Log::EMERG);
	// Assign new priority levels
	$logger->addPriority('SPECIAL', 8);
	$logger->log("******SPECIAL MESSAGE******",SPECIAL);
	// NOTE: 'TEST' will file: you cannot override message levels 0 - 7
	//$logger->addPriority('TEST', 2);
	//$logger->log("*******TEST MESSAGE********",TEST);
} catch (Zend_Wildfire_Exception $e) {
	echo '<br />' . $e->getMessage() . PHP_EOL;
	echo '<br />' . $e->getTraceAsString() . PHP_EOL;
} catch (Zend_Log_Exception $e) {
	echo '<br />' . $e->getMessage() . PHP_EOL;
	echo '<br />' . $e->getTraceAsString() . PHP_EOL;
}	
$output = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Zend_Log Filter/Formatter/Priority Example</title>
</head>
<body>
<h3>test1.log</h3>
<table>
<tr><th>Priority #</th><th>Priority Name</th><th>Timestamp</th><th>Message</th></tr>
HTML;
echo $output;
$channel->flush();
$response->sendHeaders();
ob_end_flush();
echo '</table></body></html>';
?>
