<?php
class Code_Model_ChatMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Chat_RoomController',
														'class1'	=> 'item-301',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/chat/d/controllers/p/RoomController'),
												 array( 'label' 	=> 'Chat_Plugin_InitMenu',
														'class1'	=> 'item-302',
												 		'class2'	=> 'size-10',
												 		'uri'		=> '/code/view/chat/d/plugins/p/InitMenu'),
												 array( 'label' 	=> 'Chat_Form_Post',
														'class1'	=> 'item-303',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/chat/d/forms/p/Post'),
												 array( 'label' 	=> 'Chat_Form_Messages',
														'class1'	=> 'item-304',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/chat/d/forms/p/Messages'),
												 array( 'label' 	=> 'Chat_Bootstrap',
														'class1'	=> 'item-307',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/chat/d//p/Bootstrap'),
												 ));
		return $menu;
	}
}
