<?php
require_once 'Zend/Acl.php';
require_once 'Zend/Acl/Assert/Interface.php';
require_once 'Zend/Acl/Role.php';
require_once 'Zend/Acl/Resource.php';

class utf8Assertion implements Zend_Acl_Assert_Interface
{
	public function assert(	Zend_Acl $acl,
							Zend_Acl_Role_Interface $role = null,
							Zend_Acl_Resource_Interface $resource = null,
							$privilege = null)
	{
		$lang = $_SERVER['LANG'];
		$result = (preg_match('/.*?\.utf-8$/i', $lang)) ? TRUE : FALSE;
		return $result;
	}
 	
}

$acl = new Zend_Acl();
$acl->addRole(new Zend_Acl_Role('guest'));
$acl->add(new Zend_Acl_Resource('output'));
$acl->allow('guest', 'output', 'view', new utf8Assertion());

echo ($acl->isAllowed('guest', 'output', 'view')) ? 'ALLOWED' : 'DENIED';
$lang = $_SERVER['LANG'];
echo "\n$lang";
?>
