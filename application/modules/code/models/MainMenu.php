<?php
class Code_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'View Calendar Code',
														'class1'	=> 'item-201',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/code/view/calendar/d/controllers/p/ViewController'),
												 array( 'label' 	=> 'View Chat Code',
														'class1'	=> 'item-202',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/code/view/chat/d/controllers/p/RoomController'),
												 array( 'label' 	=> 'Code View Code',
														'class1'	=> 'item-203',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/code/view/code'),
												 array( 'label' 	=> 'View Etherpad Code',
														'class1'	=> 'item-204',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/code/view/etherpad/d/controllers/p/PadController'),
												 ));
		return $menu;
	}
}
