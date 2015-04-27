<?php
// Here is the table structure:
/*
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
require_once "Zend/Db/Select.php";
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
	echo "\nSELECT * FROM students\n";
	$select = 	$db->select()
					->from('students');
	$result = $db->fetchAll($select);
	echo $select . PHP_EOL;
	var_dump($result);
	echo "\nSELECT s.*,c.* \nFROM students as s, courses as c, `student-course` as x \nWHERE s.ID = x.student_id AND c.ID = x.course_id\n";
	$select = 	$db->select()
					->from(array('s'=>'students'),array('ID','Name','Year'))
					->from(array('c'=>'courses'),array('cname'=>'Name'))
					->from(array('x'=>'student-course'))
					->where('s.ID = x.student_id')
					->where('c.ID = x.course_id');
	$result = $db->fetchAll($select);
	echo $select . PHP_EOL;
	var_dump($result);
	
} catch (Zend_Db_Adapter_Exception $e) {
    // perhaps a failed login credential, or perhaps the RDBMS is not running
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    // perhaps factory() failed to load the specified Adapter class
    echo "ERROR: " . $e->getMessage();
}
?>
