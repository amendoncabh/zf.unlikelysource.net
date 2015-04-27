<?php
/* From docs
 * http://framework.zend.com/manual/en/zend.acl.html#zend.acl.introduction.resources
 */
require "Zend/Acl.php";
//require "Zend/Acl/Role.php";
//require "Zend/Acl/Resource.php";
 
$acl = new Zend_Acl();

$acl->addRole(new Zend_Acl_Role('guest'))
    ->addRole(new Zend_Acl_Role('member'))
    ->addRole(new Zend_Acl_Role('admin'));

//$parents = array('guest','member','admin'); // uncomment this line and test
$parents = array('admin','member','guest');  	
$acl->addRole(new Zend_Acl_Role('everyone'), $parents);

$acl->add(new Zend_Acl_Resource('someResource'));

//$acl->deny('guest', 'someResource');
$acl->allow('member', 'someResource', 'view');
$acl->allow('member', 'someResource', 'edit');
//$acl->allow('guest',  'someResource', 'view');
//$acl->deny('guest',   'someResource', 'edit');
//$acl->allow('everyone', 'someResource');
//$acl->allow('admin');							// uncomment this line and test

echo "\n everyone view: ";
echo $acl->isAllowed('everyone', 'someResource', 'view') ? 'ALLOWED' : 'DENIED';
echo "\n guest view: ";
echo $acl->isAllowed('guest',    'someResource', 'view') ? 'ALLOWED' : 'DENIED';
echo "\n everyone edit: ";
echo $acl->isAllowed('everyone', 'someResource', 'edit') ? 'ALLOWED' : 'DENIED';
echo "\n guest edit: ";
echo $acl->isAllowed('guest',    'someResource', 'edit') ? 'ALLOWED' : 'DENIED';
echo "\n admin: ";
echo $acl->isAllowed('admin',    'someResource') 		 ? 'ALLOWED' : 'DENIED';
?>
