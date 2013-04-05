<?php
class Demos_Model_DemoMenu
{
	public static function getMenu()
	{
	    $options = Zend_Registry::get('options');
	    $menuList = array();
	    foreach (Demos_Model_Demos::$demos as $item) {
	        $menuList[] = new Zend_Navigation_Page_Uri(
	        	array(  'label' => ucfirst($item) . ' Demo', 
	        			'uri' 	=> 'http://' . $item . 'demo/' . $options['url']['postfix']));	    
	    }
		$menu = new Zend_Navigation($menuList);
		return $menu;
	}
}
