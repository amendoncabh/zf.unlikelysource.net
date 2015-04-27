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
$params = array (
			"host"		=> "localhost",
			"username"	=> "zend",
			"password"	=> "password",
			"dbname"	=> "zend",
			"profiler"	=> TRUE,
			"options"	=> array(Zend_Db::AUTO_QUOTE_IDENTIFIERS => true,
								 Zend_Db::ATTR_ERRMODE => Zend_Db::ERRMODE_EXCEPTION)
			);
try {
	$minCost = 90;
	$minQty = 500;
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$db->setFetchMode(Zend_db::FETCH_ASSOC);	// All the PHP fetch modes are available
	// NOTE: quoteInto only takes 1 parameter!!!
	$sql = $db->quoteInto('SELECT sku, qty_oh FROM products WHERE cost > ? AND qty_oh < ?', $minCost, $minQty);
	// using an array() as 2nd argument doesn't work either
	//$sql = $db->quoteInto('SELECT sku, qty_oh FROM products WHERE cost > ? AND qty_oh < ?', array($minCost, $minQty));
	$rows = $db->fetchAll($sql);
	echo "$sql\n";
	var_dump($rows);
	// another approach using quoteInto
	$sql = $db->quoteInto('SELECT sku, qty_oh FROM products WHERE cost > ?', $minCost)
		 . ' ' 
		 . $db->quoteInto('AND qty_oh < ?', $minQty);
	$rows = $db->fetchAll($sql);
	echo "$sql\n";
	var_dump($rows);
	// approach using quote() and quoteIdentifier()
	$sql = sprintf('SELECT %s, %s FROM %s WHERE %s > %d AND %s < %d',
				   $db->quoteIdentifier('sku'),
				   $db->quoteIdentifier('qty_oh'),
				   $db->quoteIdentifier('products'),
				   $db->quoteIdentifier('cost'),
				   $db->quote($minCost),
				   $db->quoteIdentifier('qty_oh'),
				   $db->quote($minQty));
	$rows = $db->fetchAll($sql);
	echo "$sql\n";
	var_dump($rows);
				   
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
