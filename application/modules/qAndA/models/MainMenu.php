<?php
class QAndA_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
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
