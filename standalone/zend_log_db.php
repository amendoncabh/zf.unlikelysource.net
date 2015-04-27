<?php
require "Zend/Db.php";
require "Zend/Log.php";
require "Zend/Log/Writer/Db.php";
require "Zend/Log/Formatter/Simple.php";
require "Zend/Debug.php";

$params = array (
			"host"		=> "localhost",
			"username"	=> "zend",
			"password"	=> "password",
			"dbname"	=> "zend",
//			"profiler"	=> TRUE
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$map = array('priority'			=> 'priority',
				 'priority_name'	=> 'priorityName',
				 'time'				=> 'timestamp',
				 'message'			=> 'message' );
	$logger = new Zend_Log();
	$writer = new Zend_Log_Writer_Db($db, 'log', $map);
	$logger->addWriter($writer);
	$logger->log("*****INFO MESSAGE*****",Zend_Log::INFO);
	$logger->log("*****WARNING MESSAGE*****",Zend_Log::WARN);
	$sql = 'SELECT * FROM ' . $db->quoteIdentifier('log');
	$result = $db->fetchAll($sql);
	foreach ($result as $item) {
		echo "\n" . implode(' : ', $item);
	}
} catch (Zend_Db_Adapter_Exception $e) {
    echo "ERROR: " . $e->getMessage();
    echo $e->getTraceAsString();
} catch (Zend_Log_Exception $e) {
    echo "ERROR: " . $e->getMessage();
    echo $e->getTraceAsString();
} catch (Zend_Exception $e) {
    echo "ERROR: " . $e->getMessage();
    echo $e->getTraceAsString();
}

?>