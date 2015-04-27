<?php
// Here is the table structure:
/*
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `students` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Year` int(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------
 */
require_once "Zend/Db.php";
require_once "Zend/Db/Select.php";
require_once "Zend/Db/Table.php";
class StudentTable extends Zend_Db_Table_Abstract
{
	protected $_name = 'students';
	protected $_primary = 'ID';
	protected $_cols = array('ID', 'Name', 'Year');
}
$params = array (
			'dsn'		=> 'mysql:host=localhost;dbname=zend;unix_socket=/var/run/mysqld/mysqld.sock',
			'dbname'	=> 'zend',
			'username'	=> 'test',
			'password'	=> 'password',
			'options'	=> array(Zend_Db::ATTR_ERRMODE => Zend_Db::ERRMODE_EXCEPTION),
			//'profiler'=> true,
			);
try {
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$select = 	$db->select()
					->from('students');
	$db->setFetchMode(Zend_Db::FETCH_OBJ);
	echo "\nfetchAll from adapter -- Fetch Mode FETCH_OBJ\n";
	$result = $db->fetchAll($select);
	var_dump($result);
	$table = new StudentTable($db);
	echo "\nfetchAll from table -- Fetch Mode FETCH_OBJ\n";
	$result = $table->fetchAll();
	var_dump($result);
	$db->setFetchMode(Zend_Db::FETCH_NUM);
	echo "\nfetchAll from adapter -- Fetch Mode FETCH_NUM\n";
	$result = $db->fetchAll($select);
	var_dump($result);
	$table = new StudentTable($db);
	echo "\nfetchAll from table -- Fetch Mode FETCH_NUM\n";
	$result = $table->fetchAll();
	var_dump($result);
	
	
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
