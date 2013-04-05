<?php
class Code_Model_CalendarMenu
{
	public static function getMenu()
	{
		$menu = array('type'		=>  'menu',
					  'class0'		=>	'menu',
					  'elements'	=>	array(
												 array( 'label' 	=> 'Calendar_ViewController',
														'class1'	=> 'item-301',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/calendar/d/controllers/p/ViewController'),
												 array( 'label' 	=> 'Calendar_Plugin_InitMenu',
														'class1'	=> 'item-302',
												 		'class2'	=> 'size-10',
												 		'uri'		=> '/code/view/calendar/d/plugins/p/InitMenu'),
												 array( 'label' 	=> 'Calendar_Form_YearSettings',
														'class1'	=> 'item-303',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/calendar/d/forms/p/YearSettings'),
												 array( 'label' 	=> 'Calendar_Form_MonthSettings',
														'class1'	=> 'item-304',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/calendar/d/forms/p/MonthSettings'),
												 array( 'label' 	=> 'Calendar_View_Helper_BigMonth',
														'class1'	=> 'item-305',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/calendar/d/views_helpers/p/BigMonth'),
												 array( 'label' 	=> 'Calendar_View_Helper_SmallMonth',
														'class1'	=> 'item-306',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/calendar/d/views_helpers/p/SmallMonth'),
												 array( 'label' 	=> 'Calendar_Bootstrap',
														'class1'	=> 'item-307',
												 		'class2'	=> 'size-10',
														'uri'		=> '/code/view/calendar/d//p/Bootstrap'),
												 ));
		return $menu;
	}
}
