<?php
// NOTE: still trying to figure out how to set the timeout option!!!
// messages stay in the database, but are only visible for 30 seconds
require_once 'Zend/Queue.php';
require_once 'Zend/Queue/Exception.php';
/*
 * Table structure: look in Zend/Queue/Adapter/Db for *.sql files with suggested db tables 
 * You will need 2 tables in the database: 'message' and 'queue'
 */
$options = array (
	'driverOptions' => array(
			'host'		=> 'localhost',
			'username'	=> 'zend',
			'password'	=> 'password',
			'dbname'	=> 'zend',
			'type'      => 'pdo_mysql'),
	'name'	=> 'chat'
);
$output = '';
$username = '';
$count = 0;
$clear = isset($_GET['clear']) ? TRUE : FALSE;
try {
	// set up database handle + queue
	$queue = new Zend_Queue('Db', $options);
	// receive filtered input
	$username = (isset($_POST['username'])) ? strip_tags($_POST['username']) : '';
	$message = (isset($_POST['message'])) ? strip_tags($_POST['message']) : '';
	$queue->createQueue('chat', 300);	// params = name, timeout
	if ($message) {
		$message = sprintf("%s : %s : %s", date('H:i:s d-m-Y'), $username, $message);
		$queue->send($message);
	}
	$count = $queue->count();
	if ($count) {
		$list = $queue->receive($count);
		foreach ($list as $i => $item) {
			$output .= sprintf("<br />%04d: %s\n", $i, $item->body);
			if ($clear) {
				$queue->deleteMessage($item);
			}
		}	 	
	}
} catch (Zend_Queue_Exception $e) {
	$output .= '<pre>';
    $output .= "ERROR: " . $e->getMessage();
	$output .= $e->getTraceAsString();
	$output .= '</pre>';
} catch (Zend_Exception $e) {
	$output .= '<pre>';
	$output .= "ERROR: " . $e->getMessage();
	$output .= $e->getTraceAsString();
	$output .= '</pre>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Zend Queue Chat Example</title>
</head>
<body>
<a href="?clear=yes">Clear Queue</a>
<p>
<form method="POST" action="">
<br />
Username: 
<br />
<input type="text" name="username" size=40 maxlength=40 value="<?php echo htmlspecialchars($username)?>" />
<br />
Message: 
<br />
<input type="text" name="message" size=64 maxlength=64 />
<br />
<input type="submit" name="refresh" value="Refresh" />
<input type="submit" name="postmsg" value="Post" />
</form>
<br />
Total Messages in Queue: <?php echo $count ?>
<?php echo $output ?>
</p>
</body>
</html>