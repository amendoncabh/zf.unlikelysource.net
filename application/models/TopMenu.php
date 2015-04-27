<?php
class Application_Model_TopMenu
{
	public static function getMenu()
	{
	    $options = Zend_Registry::get('options');
		$menu = new Zend_Navigation(
					array(
						new Zend_Navigation_Page_Uri(array( 'label' 		=> 'Home',
															'uri' 			=> $options['url']['home'])),
						new Zend_Navigation_Page_Mvc(array( 'label' 		=> 'Etherpad',
															'action' 		=> 'index',
															'controller' 	=> 'pad',
															'module'		=> 'etherpad')),
						new Zend_Navigation_Page_Mvc(array( 'label' 		=> 'Calendar',
															'action' 		=> 'index',
															'controller' 	=> 'view',
															'module'		=> 'calendar')),
						new Zend_Navigation_Page_Mvc(array( 'label' 		=> 'Chat',
															'action' 		=> 'visit',
															'controller' 	=> 'room',
															'module'		=> 'chat')),
						new Zend_Navigation_Page_Mvc(array( 'label' 		=> 'Q & A',
															'action' 		=> 'index',
															'controller' 	=> 'index',
															'module'		=> 'qAndA')),
						new Zend_Navigation_Page_Mvc(array( 'label' 		=> 'Demos',
															'action' 		=> 'index',
															'controller' 	=> 'index',
															'module'		=> 'demos')),
						new Zend_Navigation_Page_Uri(array( 'label' 		=> 'Code',
															'uri'			=> $options['url']['home'] . 'index/code')),
						));
		return $menu;
	}
}
