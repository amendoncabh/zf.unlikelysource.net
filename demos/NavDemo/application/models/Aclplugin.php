<?php
class Application_Model_Aclplugin
{
	public static function getAclPlugin()
	{
	    $aclPlugin = new Zend_Navigation();
	    $aclPlugin->addPage(new Zend_Navigation_Page_Mvc(array('label' 	=> 'View Green',
												               'action' 	=> 'view-green',
												               'controller' => 'aclplugin')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'View Red',
	      		  											   'action' 	=> 'view-red',
												               'controller' => 'aclplugin')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'View Yellow',
												               'action' 	=> 'view-yellow',
												               'controller' => 'aclplugin')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Edit Green',
												               'action' 	=> 'edit-green',
												               'controller' => 'aclplugin')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Edit Red',
												               'action' 	=> 'edit-red',
												               'controller' => 'aclplugin')))
	      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Edit Yellow',
												               'action' 	=> 'edit-yellow',
												               'controller' => 'aclplugin')))
	      		  ;
		return $aclPlugin;
	}
}