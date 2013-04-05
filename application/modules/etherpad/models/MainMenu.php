<?php
class Etherpad_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'View Code',
														'class1'	=> 'item-309',
//												 		'class2'	=> 'class_inside_a_tag',
												 		'uri'		=> '/code/view/etherpad/d/controllers/p/PadController'),
												 ));
		return $menu;
	}
}
