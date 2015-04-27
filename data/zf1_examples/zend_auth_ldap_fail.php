<?php
require 'Zend/Auth.php';
require 'Zend/Auth/Adapter/Ldap.php';
require 'Zend/Auth/Exception.php';
require 'Zend/Debug.php';

$auth = Zend_Auth::getInstance();
$username = 'Test';
$password = 'test';
$options =  array('server' =>  array('host' 					=> 'dc1.w.net',
									 'useStartTls' 				=> true,
									 'accountDomainName' 		=> 'w.net',
									 'accountDomainNameShort' 	=> 'W',
									 'accountCanonicalForm' 	=> '3',
									 'baseDn' 					=> 'CN=Users,DC=w,DC=net'
									 ),
								array('host' 					=> 'dc2.w.net',
									 'useStartTls' 				=> true,
									 'accountDomainName' 		=> 'w.net',
									 'accountDomainNameShort' 	=> 'W',
									 'accountCanonicalForm' 	=> '3',
									 'baseDn' 					=> 'CN=Users,DC=w,DC=net'
									 )
);
try {		 
	$adapter = new Zend_Auth_Adapter_Ldap($options, $username, $password);
	$result = $auth->authenticate($adapter);
} catch (Zend_Auth_Adapter_Exception $e) {
	$result =  'EXCEPTION: ' . PHP_EOL;
	$result .= $e->getMessage() . PHP_EOL;
	$result .= $e->getTraceAsString();
}
Zend_Debug::dump($result);
?>
