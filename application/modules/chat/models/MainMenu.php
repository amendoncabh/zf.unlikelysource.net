<?php
class Chat_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Visit Room',
														'class1'	=> 'item-201',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/chat/room/visit'),
												 array( 'label' 	=> 'Post Message',
														'class1'	=> 'item-202',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/chat/room/post'),
												));
		return $menu;
	}
}
