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
class Students extends Zend_Db_Table_Abstract
{
	protected $_name = "students";
	protected $_primary = "ID";
	protected $_dependentTables = array('StudentCourse');
}
class Courses extends Zend_Db_Table_Abstract
{
	protected $_name = "courses";
	protected $_primary = "ID";
	protected $_dependentTables = array('StudentCourse');
}
class StudentCourse extends Zend_Db_Table_Abstract
{
	protected $_name = "student-course";
	protected $_primary = array("student_id","course_id");
    protected $_referenceMap    = array(
        'Student' => array(
            'columns'           => array('student_id'),
            'refTableClass'     => 'Students',
            'refColumns'        => array('ID')
        ),
        'Courses' => array(
            'columns'           => array('course_id'),
            'refTableClass'     => 'Courses',
            'refColumns'        => array('ID')
        )
    );
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
	$students 	= new Students(array('db'=>$db));
	$courses 	= new Courses(array('db'=>$db));
	$sc			= new StudentCourse(array('db'=>$db));
	$row		= $students->fetchRow($students->select()->where('ID = ?', "1"));
	$result		= $row->findDependentRowset($sc,"Student");
	foreach($result as $item) {
		$sub_query = $item->findParentRow($sc,"Courses");
		var_dump($sub_query);
	}
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
