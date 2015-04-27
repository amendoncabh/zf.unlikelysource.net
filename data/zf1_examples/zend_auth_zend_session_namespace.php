<?php
require_once 'Zend/Db.php';
require_once 'Zend/Auth.php';
require_once 'Zend/Auth/Adapter/DbTable.php';
require_once 'Zend/Session.php';
require_once 'Zend/Session/Namespace.php';
require_once 'Zend/Debug.php';
$params = array (
			'host'		=> 'localhost',
			'username'	=> 'zend',
			'password'	=> 'password',
			'dbname'	=> 'zend',
			);
$info = '';
try {
	Zend_Session::start();
	$auth = Zend_Auth::getInstance();
	if (isset($_POST['Authenticate'])) {
	 	$db = Zend_Db::factory('PDO_MYSQL', $params);
		$name = 'admin';
		$password = 'password';
		$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password');
		$authAdapter->setIdentity($name);
		$authAdapter->setCredential($password);
		$result = $auth->authenticate($authAdapter);
		$info .= Zend_Debug::dump($result, 'Zend_Auth_Result', FALSE);
	} elseif (isset($_POST['Test'])) {
		if ($auth->hasIdentity()) {
			$info .= 'Authenticated OK as: ' . $auth->getIdentity() . '<br />';
		} else {
			$info .= 'Authenticated NOT OK';
		}
		$info .= Zend_Debug::dump($auth, 'Zend_Auth', FALSE);
	} elseif (isset($_POST['Overwrite'])) {
		$session = new Zend_Session_Namespace('Zend_Auth');
		$session->storage = 'OVERWRITE';
	}
} catch (Zend_Db_Exception $e) {
	$info .= $e->getTraceAsString();
}
$info .= Zend_Debug::dump($GLOBALS, 'GLOBALS', FALSE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Zend_Auth Test</title>
</head>
<body>
<h1>Zend_Auth Test</h1>
<hr />
<form method="POST">
<input type="submit" value="Authenticate" name="Authenticate"/>
<input type="submit" value="Test" name="Test" />
<input type="submit" value="Overwrite" name="Overwrite" />
</form>
<?php echo $info; ?>
</body>
</html>