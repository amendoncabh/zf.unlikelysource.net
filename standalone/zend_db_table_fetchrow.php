<?php
// Here is the table structure:
/*
CREATE TABLE IF NOT EXISTS `products` (
  `sku` int(8) NOT NULL COMMENT 'SKU number',
  `pid` char(32) NOT NULL COMMENT 'Product ID',
  `unit` varchar(255) NOT NULL COMMENT 'How sold',
  `cost` decimal(10,2) NOT NULL,
  `qty_oh` int(6) NOT NULL COMMENT 'Quantity on hand',
  PRIMARY KEY (`sku`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
 */
require_once "Zend/Db.php";
require_once "Zend/Db/Table/Abstract.php";
class Products extends Zend_Db_Table_Abstract
{
	protected $_name = "products";
	protected $_primary = "sku";
}
$params = array (
			'dsn'		=> 'mysql:host=localhost;dbname=zend;unix_socket=/var/run/mysqld/mysqld.sock',
			'dbname'	=> 'zend',
			'username'	=> 'test',
			'password'	=> 'password',
			'options'	=> array(Zend_Db::ATTR_ERRMODE => Zend_Db::ERRMODE_EXCEPTION),
			'profiler'	=> true,
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$products = new Products(array('db'=>$db));
	$newRow = $products->createRow();
	var_dump($newRow);
	$newRow->sku 	= "101010";
	$newRow->pid 	= "#1010";
	$newRow->unit 	= "Case/1010";
	$newRow->cost 	= "10.10";
	$newRow->qty_oh	= "101";
	$newRow->save();
	//$rows = $products->fetchRow($products->select()->where('sku = ?', "88891"));
	$where = $products->getAdapter()->quoteInto('sku = ?', "101010");
	$rows = $products->find($where);
	var_dump($rows);
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
