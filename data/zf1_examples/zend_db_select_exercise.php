<?php
require_once "Zend/Db.php";
require_once "Zend/Db/Select.php";
$params = array (
			"host"		=> "localhost",
			"username"	=> "zend",
			"password"	=> "password",
			"dbname"	=> "zend",
//			"profiler"	=> TRUE
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$select = $db->select()
				 ->from(array('p' => 'products'), array('product_id', 'product_name'))
				 ->join(array('l' => 'line_items'), 'p.product_id = l.product_id');
	echo $select;
	
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
