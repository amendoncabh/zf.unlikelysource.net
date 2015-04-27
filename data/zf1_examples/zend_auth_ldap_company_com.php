<?php
require 'Zend/Auth.php';
require 'Zend/Auth/Adapter/Ldap.php';
require 'Zend/Auth/Exception.php';
require 'Zend/Debug.php';

$auth = Zend_Auth::getInstance();
$username = 'cn=groucho,ou=onlinemarket,dc=company,dc=com';
$password = 'password';
// NOTE: assumes you have a VM at this address running openLDAP
$options =  array('server' =>  array('host' 					=> 'ldap.company.com',
									 'port'						=> 389,
									 'useStartTls' 				=> FALSE,
									 'accountDomainName' 		=> 'company.com',
									 'accountDomainNameShort' 	=> 'company',
									 // NOTE: use canonical form 3 for Active Directory
									 'accountCanonicalForm' 	=> '1',
									 'baseDn' 					=> 'ou=onlinemarket,dc=company,dc=com'
									 ),
);
try {		 
	$adapter = new Zend_Auth_Adapter_Ldap($options, $username, $password);
	$result  = $auth->authenticate($adapter);
	$ldap    = $adapter->getLdap();
	$storage = $auth->getStorage();
	$storage->write($ldap);
} catch (Zend_Auth_Adapter_Exception $e) {
	$result =  'EXCEPTION: ' . PHP_EOL;
	$result .= $e->getMessage() . PHP_EOL;
	$result .= $e->getTraceAsString();
}
Zend_Debug::dump($result, 'RESULT:' . PHP_EOL);
Zend_Debug::dump($ldap, 'LDAP:' . PHP_EOL);
Zend_Debug::dump($_SESSION['Zend_Auth'], 'Zend_Auth:' . PHP_EOL);
