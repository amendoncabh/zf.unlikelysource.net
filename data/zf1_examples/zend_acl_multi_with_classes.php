<?php
/* 
 * Question from Steven
 */
require "Zend/Acl.php";
require "Zend/Acl/Role.php";
require "Zend/Acl/Resource.php";

class TestResource implements Zend_Acl_Resource_Interface
{ 
	public function getResourceId() { return 'testResource'; } 
}
class GuestRole implements Zend_Acl_Role_Interface
{ 
	public function getRoleId() { return 'guest'; } 
}
class MemberRole implements Zend_Acl_Role_Interface
{ 
	public function getRoleId() { return 'member'; } 
}
class AdminRole implements Zend_Acl_Role_Interface
{ 
	public function getRoleId() { return 'admin'; } 
}

$guest = new GuestRole();
$member = new MemberRole();
$admin = new AdminRole();
$resource = new TestResource();

$acl = new Zend_Acl();

$acl->addRole($guest)
    ->addRole($member)
    ->addRole($admin);

$acl->add($resource);

$acl->deny($guest, $resource);
$acl->allow($member, $resource);
$acl->allow($admin);

echo "\nGuest: ";
echo $acl->isAllowed($guest, $resource) ? 'allowed' : 'denied';
echo "\nMember: ";
echo $acl->isAllowed($member, $resource) ? 'allowed' : 'denied';
echo "\nAdmin: ";
echo $acl->isAllowed($admin, $resource) ? 'allowed' : 'denied';
?>
