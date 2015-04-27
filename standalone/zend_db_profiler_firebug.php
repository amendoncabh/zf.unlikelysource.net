<?php
// NOTE: requires that both Firebug and FirePHP be installed as Firefox Add-ons!
require_once 'Zend/Db.php';
require_once 'Zend/Db/Profiler/Firebug.php';
require_once 'Zend/Controller/Request/Http.php';
require_once 'Zend/Controller/Response/Http.php';
require_once 'Zend/Wildfire/Channel/HttpHeaders.php';
$params = array (
			'dsn'		=> 'mysql:host=localhost;dbname=zend;unix_socket=/var/run/mysqld/mysqld.sock',
			'dbname'	=> 'zend',
			'username'	=> 'test',
			'password'	=> 'password',
			'options'	=> array(Zend_Db::ATTR_ERRMODE => Zend_Db::ERRMODE_EXCEPTION),
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$db->getConnection();
	$profile = new Zend_Db_Profiler_Firebug('All DB Queries');
	$profile->setEnabled(TRUE);
	$db->setProfiler($profile);
	// Attach the profiler to your db adapter
	$request  = new Zend_Controller_Request_Http();
	$response = new Zend_Controller_Response_Http();
	$channel  = Zend_Wildfire_Channel_HttpHeaders::getInstance();
	$channel->setRequest($request);
	$channel->setResponse($response);
	// Start output buffering
	ob_start();
	$sql = 'SELECT sku FROM products';
	$result = $db->fetchAll($sql);
	$output = "";
	$x = 0;
	foreach($result as $row) {
		$sql = 'SELECT sku FROM products WHERE sku = ?';
		$sub_result = $db->fetchAll($sql,$row['sku']);
		$output .= $x++ . " ";
	}
	$output .= "<table width=80%>\n";
	$output .= "<tr><th>Total Number Queries</th><td>" . $profile->getTotalNumQueries() .  "</td></tr>\n";
	$output .= "<tr><th>Total Elapsed Seconds</th><td>" . $profile->getTotalElapsedSecs() .  "</td></tr>\n";
	$output .= "<tr><th>Last Query Profile</th><td><pre>" . var_export($profile->getLastQueryProfile(),TRUE) .  "</pre></td></tr>\n";
	$output .= "<tr><th>Query Profiles</th><td><pre>" . var_export($profile->getQueryProfiles(),TRUE) . "</td></tr>\n";
	$output .= "</table>\n";
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    $output .= "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    $output .= "ERROR: " . $e->getMessage();
}
// Flush profiling data to browser
echo $output;
$channel->flush();
$response->sendHeaders();
ob_flush();