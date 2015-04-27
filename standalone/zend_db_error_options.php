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
 */
require_once "Zend/Db.php";
require_once "Zend/Db/Select.php";
$options = array(Zend_Db::ATTR_ERRMODE 				=> Zend_Db::ERRMODE_EXCEPTION,
				 Zend_Db::ATTR_PERSISTENT			=> false,
				 Zend_Db::AUTO_QUOTE_IDENTIFIERS	=> true);
$params = array (
			'dsn'		=> 'mysql:host=localhost;dbname=zend;unix_socket=/var/run/mysqld/mysqld.sock',
			'dbname'	=> 'zend',
			'username'	=> 'test',
			'password'	=> 'password',
			'options'	=> $options,
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$result = $db->fetchAll('BAD SQL STATEMENT');
	foreach ($result as $line) {
		echo "\n" . implode(' : ', $line);
	}
	
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
