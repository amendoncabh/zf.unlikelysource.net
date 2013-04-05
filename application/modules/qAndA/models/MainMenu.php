<?php
class QAndA_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Search',
														'class1'	=> 'item-201',
														'uri'		=> '/qAndA/index/search'),
												 array( 'label' 	=> 'View Code',
														'class1'	=> 'item-209',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/code/view/qAndA/d/controllers/p/IndexController'),
												));
		return $menu;
	}
	
	public static function getAdminMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Build New Index',
														'class1'	=> 'item-201',
														'uri'		=> '/qAndA/index/build'),
												));
		return $menu;
	}
}
