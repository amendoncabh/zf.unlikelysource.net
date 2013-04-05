<?php
class Chat_Bootstrap extends Zend_Application_Module_Bootstrap
{
	protected function _initPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
		$initMenu = new Chat_Plugin_InitMenu();
		$front->registerPlugin($initMenu);
	}
	
}