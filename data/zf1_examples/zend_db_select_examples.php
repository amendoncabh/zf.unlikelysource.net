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
			"profiler"	=> TRUE,
			"options"	=> array(Zend_Db::AUTO_QUOTE_IDENTIFIERS => true)
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$table = new Products(array('db'=>$db));
	$db->setFetchMode(Zend_db::FETCH_ASSOC);	// All the PHP fetch modes are available
	$select1 = $table->select();
	$select  = $table->select ();
	
	// Build this query (date('now') is used in SQLite):
	// SELECT date('now') 
	$select1->from('products', 
				   array('now' => "date('now')"));	
	echo $select1 . "<br />\n";
	// Build this query:
	// SELECT p.sku, p.qty_oh AS q FROM products AS p
	$select->from(array('p' => 'products'), 
				  array('sku', 'q' => 'qty_oh', 'AVG(cost)'));	
	$select->where('cost > ?', 90);
	$select->where('qty_oh < ?', 100);
	$select->orWhere('cost = ?', 50);
	echo $select . "<br />\n";
	$rows = $table->fetchAll($select);
	echo "<br /><pre>\n";
	var_dump($rows);
	echo "</pre>\n";
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
