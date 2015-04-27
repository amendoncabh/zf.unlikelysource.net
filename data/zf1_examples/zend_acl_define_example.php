<?php
/* From docs
 * http://framework.zend.com/manual/en/zend.acl.html#zend.acl.introduction.resources
 * 2.1.5
 */
require "Zend/Acl.php";
require "Zend/Acl/Role.php";

$acl = new Zend_Acl();

$roleGuest = new Zend_Acl_Role('guest');
$acl->addRole($roleGuest);
$acl->addRole(new Zend_Acl_Role('staff'), $roleGuest);
$acl->addRole(new Zend_Acl_Role('editor'), 'staff');
$acl->addRole(new Zend_Acl_Role('administrator'));

// Guest may only view content
$acl->allow($roleGuest, null, 'view');

/*
Alternatively, the above could be written:
$acl->allow('guest', null, 'view');
//*/

// Staff inherits view privilege from guest, but also needs additional
// privileges
$acl->allow('staff', null, array('edit', 'submit', 'revise'));

// Editor inherits view, edit, submit, and revise privileges from
// staff, but also needs additional privileges
$acl->allow('editor', null, array('publish', 'archive', 'delete'));

// Administrator inherits nothing, but is allowed all privileges
$acl->allow('administrator');

// Query ACL
allowDeny($acl,'guest','view');
// allowed

allowDeny($acl,'staff','publish');
// denied

allowDeny($acl,'staff','revise');
// allowed

allowDeny($acl,'editor', 'view');
// allowed because of inheritance from guest

allowDeny($acl,'editor', 'update');
// denied because no allow rule for 'update'

allowDeny($acl,'administrator', 'view');
// allowed because administrator is allowed all privileges

allowDeny($acl,'administrator', NULL);
// allowed because administrator is allowed all privileges

allowDeny($acl,'administrator','update');
// allowed because administrator is allowed all privileges

function allowDeny(Zend_Acl $acl,$who,$what)
{
	$access = $acl->isAllowed($who, null, $what) ? "allowed" : "denied";
	printf("\n%s  -  %s:   %s", $who, $what, $access);
}