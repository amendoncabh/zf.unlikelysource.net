<?php
require "Zend/Log.php";
require "Zend/Log/Writer/Stream.php";
define('SPECIAL', 8);
define('TEST', 2);
// Set up log and 2 writers
try {
	$logger = new Zend_Log();
	$writer1 = new Zend_Log_Writer_Stream('test1.log');
	$writer2 = new Zend_Log_Writer_Stream('test2.log');
	$logger->addWriter($writer1);
	$logger->addWriter($writer2);
	// Add filter to #2
	$filter = new Zend_Log_Filter_Priority(Zend_Log::CRIT);
	$writer2->addFilter($filter);
	// Assign formatter to both writers
	$format = new Zend_Log_Formatter_Simple('<tr><td>%priority%</td><td>%priorityName%</td><td>%timestamp%</td><td>%message%</td></td></tr>');
	$writer1->setFormatter($format);
	$writer2->setFormatter($format);
	// Log some messages
	$logger->log("*******INFO MESSAGE********",Zend_Log::INFO);
	$logger->log("*****EMERGENCY MESSAGE*****",Zend_Log::EMERG);
	// Assign new priority levels
	$logger->addPriority('SPECIAL', 8);
	$logger->log("******SPECIAL MESSAGE******",SPECIAL);
	$logger->addPriority('TEST', 2);
	$logger->log("*******TEST MESSAGE********",TEST);
} catch (Zend_Log_Exception $e) {
	echo '<br />' . $e->getMessage() . PHP_EOL;
	echo '<br />' . $e->getTraceAsString() . PHP_EOL;
}	
?>
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
<?php readfile("test1.log") ?>
</table>
<h3>test2.log</h3>
<table>
<tr><th>Priority #</th><th>Priority Name</th><th>Timestamp</th><th>Message</th></tr>
<?php readfile("test2.log") ?>
</table>
</body>
</html>
