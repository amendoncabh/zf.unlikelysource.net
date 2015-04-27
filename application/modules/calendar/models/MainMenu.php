<?php
class Calendar_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Year',
														'class1'	=> 'item-201',
														'uri'		=> '/calendar/view/year'),
												 array( 'label' 	=> 'Month', 
														'class1'	=> 'item-202',
														'uri'		=> '/calendar/view/month'),
												));
		return $menu;
	}
}
