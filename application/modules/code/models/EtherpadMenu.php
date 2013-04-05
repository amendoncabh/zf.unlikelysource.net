<?php
class Code_Model_EtherpadMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Etherpad_PadController',
														'class1'	=> 'item-301',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/etherpad/d/controllers/p/PadController'),
												 array( 'label' 	=> 'Etherpad_Plugin_InitMenu',
														'class1'	=> 'item-302',
												 		'class2'	=> 'size-10',
												 		'uri'		=> '/code/view/etherpad/d/plugins/p/InitMenu'),
												 array( 'label' 	=> 'Etherpad_Form_Pad',
														'class1'	=> 'item-303',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/etherpad/d/forms/p/Pad'),
												 array( 'label' 	=> 'Etherpad_Form_Controls',
														'class1'	=> 'item-304',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/etherpad/d/forms/p/Controls'),
												 array( 'label' 	=> 'Etherpad_Bootstrap',
														'class1'	=> 'item-307',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/etherpad/d//p/Bootstrap'),
												 ));
		return $menu;
	}
}
