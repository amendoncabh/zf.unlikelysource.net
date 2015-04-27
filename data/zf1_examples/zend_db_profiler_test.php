<?php
require_once 'Zend/Db.php';
$params = array (
			'host'		=> 'localhost',
			'username'	=> 'zend',
			'password'	=> 'password',
			'dbname'	=> 'zend',
			'profiler'	=> TRUE
			);
try {
	$secs = 0;
	$max = 0;
	$max_query = '';
	$x = 0;
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$db->getConnection();	// this technique forces the connection immediately
	$profile = $db->getProfiler();
	$profile->setEnabled(TRUE);		// Not needed: set on line 8
	$sql = 'SELECT sku FROM products';
	$result = $db->fetchAll($sql);
	foreach($result as $row) {
		$sql = 'SELECT sku FROM products WHERE sku = ?';
		$sub_result = $db->fetchAll($db->quoteInto($sql, $row['sku']));
		echo ++$x . ' ';
		$secs = $profile->getLastQueryProfile()->getElapsedSecs();
		if ($secs > $max) {
			$max = $secs;
			$max_query = $profile->getLastQueryProfile();
		}
	}
	echo "<table width=80% border=1>\n";
	echo "<tr><th>Longest Query (in seconds)</th><td>" . $max .  "</td></tr>\n";
	echo "<tr><th>Longest Query Profile</th><td><pre>" . var_export($max_query,TRUE) .  "</pre></td></tr>\n";
	echo "<tr><th>Total Number Queries</th><td>" . $profile->getTotalNumQueries() .  "</td></tr>\n";
	echo "<tr><th>Total Elapsed Seconds</th><td>" . $profile->getTotalElapsedSecs() .  "</td></tr>\n";
	echo "<tr><th>Last Query Profile</th><td><pre>" . var_export($profile->getLastQueryProfile(),TRUE) .  "</pre></td></tr>\n";
	echo "<tr><th>Query Profiles</th><td><pre>" . var_export($profile->getQueryProfiles(),TRUE) . "</td></tr>\n";
	echo "</table>\n";
	$profile->setEnabled(FALSE);
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo 'ERROR: ' . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo 'ERROR: ' . $e->getMessage();
}
?>
