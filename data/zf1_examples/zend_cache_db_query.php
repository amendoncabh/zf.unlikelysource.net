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
require 'Zend/Cache/Exception.php';
require 'Zend/Cache.php';
require 'Zend/Cache/Core.php';
require 'Zend/Cache/Backend/File.php';

// set params
$start = (isset($_GET['start'])) ? (int) $_GET['start'] : 0;
$stop  = (isset($_GET['stop']))  ? (int) $_GET['stop']  : 0;

// get previous params from hidden variables
$oldStart = (isset($_GET['oldStart'])) ? $_GET['oldStart'] : 0;
$oldStop  = (isset($_GET['oldStop']))  ? $_GET['oldStop']  : 0;

// check to see if $start and $stop are set
if (!$start) {
	$start = $oldStart ?: 10000;
}
if (!$stop) {
	$stop = $oldStop ?: 19999;
}

// set up the cache object
$frontendOptions = array(
	'automatic_serialization' => TRUE,
	'lifetime' => 10 // cache lifetime of 10 seconds
);
$backendOptions = array(
	'cache_dir' => '/tmp/' // Directory where to put the cache files
);
$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);	

// database params
$params = array (
			"host"		=> "localhost",
			"username"	=> "zend",
			"password"	=> "password",
			"dbname"	=> "zend",
			"profiler"	=> FALSE
			);
			
// init variables
$output = '';
$result = array();
try {
	
	// database connection
	$db = Zend_Db::factory('PDO_MYSQL', $params);
	$select = $db->select()
				 ->from('names')
				 ->where('zip >= ?', $start)
				 ->where('zip <= ?', $stop);
	
	// if params have changed, refresh cache
	if ($start && $stop && ($start <> $oldStart || $stop <> $oldStop)) {
		$output = 'Parameters Changed / Cache Refreshed';
		$result = $db->fetchAll($select);
		$cache->save($result, 'dbquery');
		$oldStart = ($start) ? $start : 10000;
		$oldStop  = ($stop) ? $stop : 19999;
	} else {
		// check to see if cache is valid
		if ($result = $cache->load('dbquery')) {
			$output = 'Results From Cache';
		} else {
			$output = 'Cache Unavailable / Cache Refreshed';
			$result = $db->fetchAll($select);
			$cache->save($result, 'dbquery');
		}
	}
	$output .= "<br />$start : $stop : $oldStart : $oldStop <br />";
	
} catch (Zend_Db_Adapter_Exception $e) {
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Cache_Exception $e) {
    echo "ERROR: " . $e->getMessage();
} catch (Zend_Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Zend_Cache DB Query Example</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.18" />
</head>
<body>
<h3>Zend_Cache DB Query Example</h3>
<hr />
<?php echo $output; ?>
<br />
<form method="get"> 
Zip Start: <input type="text" name="start" />
<br />
Zip Stop:  <input type="text" name="stop" />
<br />
<input type="submit" />
<input type="hidden" name="oldStart" value=<?php echo $oldStart; ?> />
<input type="hidden" name="oldStop" value=<?php echo $oldStop; ?> />
</form>
<br />
<!-- Loop through results -->
<?php 
foreach ($result as $row) {
	echo '<br />' . implode(' : ', $row);
}
?>
</body>
</html>
