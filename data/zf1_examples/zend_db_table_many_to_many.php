<?php
/* Table Structures
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `courses` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `student-course` (
  `student_id` int(8) NOT NULL,
  `course_id` int(4) NOT NULL,
  PRIMARY KEY (`student_id`,`course_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
require_once "Zend/Db/Table/Abstract.php";
class Students extends Zend_Db_Table_Abstract
{
	protected $_name = "students";
	protected $_primary = "ID";
	protected $_dependentTables = array('StudentCourse');
    protected $_referenceMap    = array(
        'Student2Course' => array(
            'columns'           => array('ID'),
            'refTableClass'     => 'StudentCourse',
            'refColumns'        => array('student_id')
        ));
}
class Courses extends Zend_Db_Table_Abstract
{
	protected $_name = "courses";
	protected $_primary = "ID";
	protected $_dependentTables = array('StudentCourse');
    protected $_referenceMap    = array(
        'Course2Student' => array(
            'columns'           => array('ID'),
            'refTableClass'     => 'StudentCourse',
            'refColumns'        => array('course_id')
        ));
}
class StudentCourse extends Zend_Db_Table_Abstract
{
	protected $_name = "student-course";
	protected $_primary = array("student_id","course_id");
	protected $_dependentTables = array('Students','Courses');
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
	$rowset		= $students->find(2)->current()->findManyToManyRowset($courses,$sc);
	$profile = $db->getProfiler();
	echo '<pre>';
	var_dump($profile->getLastQueryProfile());
	var_dump($rowset);
	echo '</pre>';
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
