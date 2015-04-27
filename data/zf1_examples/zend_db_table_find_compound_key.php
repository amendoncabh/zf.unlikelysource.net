<?php
// Here is the table structure:
/*
CREATE TABLE IF NOT EXISTS `purchases` (
  `sku` int(8) NOT NULL COMMENT 'Product SKU Num',
  `po_num` char(32) NOT NULL COMMENT 'Purchase Order',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Purchase Date',
  `qty` int(8) NOT NULL COMMENT 'Qty Purchased',
  `price` decimal(10,2) NOT NULL COMMENT 'Selling Price',
  PRIMARY KEY (`sku`,`po_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
 */
require_once 'Zend/Db.php';
require_once 'Zend/Db/Table/Abstract.php';
require_once 'Zend/Debug.php';

class Purchases extends Zend_Db_Table_Abstract
{
	protected $_name = 'purchases';
	protected $_primary = array('sku','po_num');
}
$params = array (
			'host'		=> 'localhost',
			'username'	=> 'zend',
			'password'	=> 'password',
			'dbname'	=> 'zend',
			'profiler'	=> TRUE
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$table = new Purchases(array('db'=>$db));
	$result = $table->find('15758','1015');
	Zend_Debug::dump($result, 'COMPOUND KEY - SINGLE QUERY');
	// Example of retrieving multiple records w/ compound keys:
	$result = $table->find(array('11971','1001'), array('16755','1008'));
	Zend_Debug::dump($result, 'COMPOUND KEY - MULTIPLE QUERY');
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo 'ERROR: ' . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo 'ERROR: ' . $e->getMessage();
}
?>
