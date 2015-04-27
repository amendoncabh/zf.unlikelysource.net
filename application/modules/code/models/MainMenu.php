<?php
class Code_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
							 array( 'label' 	=> 'View Code',
									'class1'	=> 'item-201',
									'uri'		=> '/code/view/index'),
							));
		return $menu;
	}
}
