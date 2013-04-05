<?php
class Application_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Home',
														'class1'	=> 'item-100 current active',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/'),
												 array( 'label' 	=> 'Zend Framework Q & A',
														'class1'	=> 'item-101',
														'uri'		=> '/qAndA/index/index'),
												 array( 'label' 	=> 'zf 1.5 ref',
														'uri'		=> 'http://zf.unlikelysource.net/manual/1.5/en/'),
					  							array( 'label' 		=> 'unlikelysource.com',
														'uri'		=> 'http://unlikelysource.com/'),
												 array( 'label' 	=> 'unlikelysource.net',
														'uri'		=> 'http://unlikelysource.net/'),
												 array( 'label' 	=> 'zf2.unlikelysource.org',
														'uri'		=> 'http://zf2.unlikelysource.org/')
					  ));
		return $menu;
	}
}
