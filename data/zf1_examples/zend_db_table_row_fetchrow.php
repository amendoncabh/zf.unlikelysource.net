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
			"host"		=> "localhost",
			"username"	=> "zend",
			"password"	=> "password",
			"dbname"	=> "zend",
			"profiler"	=> TRUE
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$products = new Products(array('db'=>$db));
	$newRow = $products->createRow();
	$newRow->sku 	= "88888";
	$newRow->pid 	= "#88";
	$newRow->unit 	= "Case/88";
	$newRow->cost 	= "88.88";
	$newRow->qty_oh	= "88";
	$newRow->save();
	$rows = $products->fetchRow($products->select()->where('sku = ?', "88888"));
	var_dump($rows);
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
