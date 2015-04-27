<?php
// Here is the table structure for /workspace/wikiapp/application/data/wikidb.sqlite
/*
CREATE TABLE [wikiusers] ( [user_id] INTEGER  NOT NULL PRIMARY KEY, [username] VARCHAR(50) UNIQUE NOT NULL, [password] VARCHAR(32) NULL, [real_name] VARCHAR(150) NULL)
CREATE TABLE listings (user_id int, listing_id INTEGER PRIMARY KEY, title VARCHAR(120), content TEXT, modified DATETIME)

Assignment: modify the code using JOIN to produce a listing of usernames, titles, and dates

 */
require_once "Zend/Db.php";
require_once "Zend/Db/Select.php";
$db_loc = "/workspace/wikiapp/application/data/wikidb.sqlite";
$params = array ( "dbname" => $db_loc );
try {
	$db = Zend_Db::factory('PDO_SQLITE', $params);
	echo "\nSELECT * FROM wikiusers\n";
	$select = 	$db->select()->from('wikiusers');
	$stmt = $db->query($select);
	$result = $stmt->fetchAll();
	var_dump($result);
	echo "\nSELECT * FROM listings\n";
	$select = 	$db->select()->from('listings');
	$stmt = $db->query($select);
	$result = $stmt->fetchAll();
	var_dump($result);
	
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
