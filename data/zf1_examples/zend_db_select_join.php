<?php
// Here is the table structure:
/*
--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `sku` int(8) NOT NULL COMMENT 'SKU number',
  `pid` char(32) NOT NULL COMMENT 'Product ID',
  `unit` varchar(255) NOT NULL COMMENT 'How sold',
  `cost` decimal(10,2) NOT NULL,
  `qty_oh` int(6) NOT NULL COMMENT 'Quantity on hand',
  PRIMARY KEY (`sku`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--
-- Table structure for table `purchases`
--
CREATE TABLE IF NOT EXISTS `purchases` (
  `sku` int(8) NOT NULL COMMENT 'Product SKU Num',
  `po_num` char(32) NOT NULL COMMENT 'Purchase Order',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Purchase Date',
  `qty` int(8) NOT NULL COMMENT 'Qty Purchased',
  `price` decimal(10,2) NOT NULL COMMENT 'Selling Price',
  PRIMARY KEY (`sku`,`po_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

 */
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
	// inner join
	echo '<pre>';
	echo "\n-----------------------------------------------------------------\n";
	echo "\nSELECT p.sku, p.pid, c.* FROM 'products' AS p"
	   . "\nJOIN 'purchases' AS c"
	   . "\nON p.sku = c.sku";
	echo "\n-----------------------------------------------------------------\n";
	$select = 	$db->select()
					->from(array('p' => 'products'), array('sku', 'pid'))
					->join(array('c' => 'purchases'), 'p.sku = c.sku');	// source table, join clause, [columns]
	echo $select . "\n";
	$result = $db->fetchAll($select);
	foreach ($result as $line) {
		echo "\n" . implode(' : ', $line);
	}
	// left join
	echo "\n-----------------------------------------------------------------\n";
	echo "\nSELECT p.sku, p.pid, c.* FROM 'products' AS p"
	   . "\nLEFT JOIN 'purchases' AS c"
	   . "\nON p.sku = c.sku";
	echo "\n-----------------------------------------------------------------\n";
	$select = 	$db->select()
					->from(array('p' => 'products'), array('sku', 'pid'))
					->joinLeft(array('c' => 'purchases'), 'p.sku = c.sku');
	echo $select . "\n";
	$result = $db->fetchAll($select);
	foreach ($result as $line) {
		echo "\n" . implode(' : ', $line);
	}
	// right join
	echo "\n-----------------------------------------------------------------\n";
	echo "\nSELECT p.sku, p.pid, c.* FROM 'products' AS p"
	   . "\nRIGHT JOIN 'purchases' AS c"
	   . "\nON p.sku = c.sku";
	echo "\n-----------------------------------------------------------------\n";
	$select = 	$db->select()
					->from(array('p' => 'products'), array('sku', 'pid'))
					->joinRight(array('c' => 'purchases'), 'p.sku = c.sku');
	echo $select . "\n";
	$result = $db->fetchAll($select);
	foreach ($result as $line) {
		echo "\n" . implode(' : ', $line);
	}
	// natural join
	echo "\n-----------------------------------------------------------------\n";
	echo "\nSELECT p.sku, p.pid, c.* FROM 'products' AS p"
	   . "\nNATURAL JOIN 'purchases' AS c";
	echo "\n-----------------------------------------------------------------\n";
	$select = 	$db->select()
					->from(array('p' => 'products'), array('sku', 'pid'))
					->joinNatural(array('c' => 'purchases'));
	echo $select . "\n";
	$result = $db->fetchAll($select);
	foreach ($result as $line) {
		echo "\n" . implode(' : ', $line);
	}
	// cross join
	echo "\n-----------------------------------------------------------------\n";
	echo "\nSELECT p.sku, p.pid, c.* FROM 'products' AS p"
	   . "\nCROSS JOIN 'purchases' AS c";
	echo "\n-----------------------------------------------------------------\n";
	$select = 	$db->select()
					->from(array('p' => 'products'), array('sku', 'pid'))
					->joinCross(array('c' => 'purchases'));
	echo $select . "\n";
	$result = $db->fetchAll($select);
	foreach ($result as $line) {
		echo "\n" . implode(' : ', $line);
	}
	echo '</pre>';
	
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
