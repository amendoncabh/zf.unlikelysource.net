<?php
class Model_Menu
{
	public static function getMenu()
	{
         $menu = new Zend_Navigation();
	     $menu->addPage(new Zend_Navigation_Page_Mvc(array('label' 	=> 'Home',
											               'action' 	=> 'index',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Login',
											               'action' 	=> 'login',
											               'controller' => 'form')))
	     	  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'User Info',
											               'action' 	=> 'userinfo',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Form Helpers',
											               'action' 	=> 'userwithhelpers',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'resources.view',
											               'action' 	=> 'notfound',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Books',
											               'action' 	=> 'book',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'HTML Table',
											               'action' 	=> 'address',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Dojo',
											               'action' 	=> 'index',
											               'controller' => 'dojo')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Locale',
											               'action' 	=> 'index',
											               'controller' => 'locale')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Escape',
											               'action' 	=> 'escape-test',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Decorator',
											               'action' 	=> 'decorator-test',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'Subforms',
											               'action' 	=> 'subforms',
											               'controller' => 'form')))
      		  ->addPage(new Zend_Navigation_Page_Mvc(array('label' 		=> 'NotEmpty',
											               'action' 	=> 'not-empty',
											               'controller' => 'form')))
      		  ;
	    return $menu;
	}
}