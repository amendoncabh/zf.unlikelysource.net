<?php
class Application_Model_Aclmenu
{
	public static function getAclMenu()
	{
	      $aclMenu = new Zend_Navigation();
	      $aclMenu->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'View Green',
	      													   'order'		=> '-1',
	      													   'resource'	=> 'viewMenuGreen',
												               'action' 	=> 'view-green',
												               'controller' => 'acltest')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'View Red',
	      													   'order'		=> '-11',
	      		  											   'resource'	=> 'viewMenuRed',
	      		  											   'action' 	=> 'view-red',
												               'controller' => 'acltest')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'View Yellow',
	      		  											   'resource'	=> 'viewMenuYellow',
												               'action' 	=> 'view-yellow',
												               'controller' => 'acltest')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Edit Green',
	      		  											   'resource'	=> 'editMenuGreen',
												               'action' 	=> 'edit-green',
												               'controller' => 'acltest')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Edit Red',
	      		  											   'resource'	=> 'editMenuRed',
												               'action' 	=> 'edit-red',
												               'controller' => 'acltest')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Edit Yellow',
	      		  											   'resource'	=> 'editMenuYellow',
												               'action' 	=> 'edit-yellow',
												               'controller' => 'acltest')))
	      		  ;
	    return $aclMenu;
	}
}