<?php
require_once "Zend/Db.php";
require_once "Zend/Db/Table/Abstract.php";
class Products extends Zend_Db_Table_Abstract
{
	protected $_name = "products";
	protected $_primary = "sku";
	protected $_dependentTables = array('Purchases');
}
class Purchases extends Zend_Db_Table_Abstract
{
	protected $_name = "purchases";
	protected $_primary = array("sku","po_num");
    protected $_referenceMap    = array(
        'Link' => array(
            'columns'           => array('sku'),
            'refTableClass'     => 'Products',
            'refColumns'        => array('sku')
        )
    );
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
	$products	= new Products(array('db'=>$db));
	$purchases	= new Purchases(array('db'=>$db));
	$row		= $products->fetchRow($products->select()->where('sku = ?', "16790"));
	$child		= $row->findDependentRowset($purchases,"Link");
	echo "\nChild Rows------------------------------------\n";
	var_dump($child);
	foreach($child as $item) {
		echo "\nParent Row -----------------------------------\n";
		$parent = $item->findParentRow($products,"Link");
		var_dump($parent);
	}
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
