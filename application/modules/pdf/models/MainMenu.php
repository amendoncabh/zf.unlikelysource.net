<?php
class Pdf_Model_MainMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Add Images',
														'class1'	=> 'item-201',
														'uri'		=> '/pdf/fromjpg/index'),
												 array( 'label' 	=> 'Create PDF', 
														'class1'	=> 'item-202',
														'uri'		=> '/pdf/fromjpg/generate'),
												 array( 'label' 	=> 'View Code',
														'class1'	=> 'item-209',
//												 		'class2'	=> 'class_inside_a_tag',	
												 		'uri'		=> '/code/view/pdf/d/controllers/p/FrompdfController'),
												));
		return $menu;
	}
}
