<?php
// Here is the 'names' table structure (5000 records):
/*
CREATE TABLE IF NOT EXISTS `names` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `zip` int(5) NOT NULL,
  `phone` char(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100000 ;
 */

require 'Zend/Db.php';
require 'Zend/Db/Adapter/Exception.php';
require 'Zend/Paginator.php';
require 'Zend/Paginator/Exception.php';
require 'Zend/Paginator/Adapter/DbSelect.php';

$params = array (
			"host"		=> "localhost",
			"username"	=> "zend",
			"password"	=> "password",
			"dbname"	=> "zend",
			"profiler"	=> FALSE
			);
try {
	$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
	$next = $page + 1;
	$prev = $page - 1;
	$sort = (isset($_GET['sort'])) ? strip_tags($_GET['sort']) : 'ln';
	switch ($sort) {
		case 'c' :
			$order = 'city';
			break;
		case 'z' :
			$order = 'zip';
			break;
		case 'fn' :
			$order = 'first_name';
			break;
		case 'i' :
			$order = 'id';
			break;
		case 'p' :
			$order = 'phone';
			break;
		case 'a' :
			$order = 'address';
			break;
		case 's' :
			$order = 'state';
			break;
		default :
			$order = 'last_name';
			break;
	}
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$select = $db->select()->from('names')->order($order);
	$paginator = Zend_Paginator::factory($select);
	$paginator->setCurrentPageNumber($page);
	$paginator->setItemCountPerPage(20);
} catch (Zend_Db_Adapter_Exception $e) {
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Paginator_Exception $e) {
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Zend_Paginator Example</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.18" />
</head>

<body>
<h3>Names Table = 5000 records total</h3>
<hr />
<br />
<pre>
<?php 
echo '   <a href="?sort=i">id</a> |' . 
	 '       <a href="?sort=fn">first name</a> |' . 
	 '        <a href="?sort=ln">last name</a> |' . 
     '                                  <a href="?sort=a">address</a> |' . 
     '                      <a href="?sort=c">city</a> |' .
     '            <a href="?sort=s">state</a> |' . 
     '   <a href="?sort=z">zip</a> |' . 
     '        <a href="?sort=p">phone</a>';
foreach ($paginator as $item) {
	echo vsprintf("<br />%05d | %16s | %16s | %40s | %25s | %16s | %5d | %12s", $item);
} 
?>	
</pre>
<hr />
<a href="/php_zff/zend_paginator.php?page=<?php echo $prev ?>&sort=<?php echo $sort ?>">Prev</a>
<------------------------------------------>
<a href="/php_zff/zend_paginator.php?page=<?php echo $next ?>&sort=<?php echo $sort ?>">Next</a>
&nbsp;&nbsp;&nbsp;
NOTE: click on title to change sort order
<p><?php echo $select ?></p>
</body>
</html>
