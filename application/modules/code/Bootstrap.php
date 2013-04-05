<?php
class Code_Bootstrap extends Zend_Application_Module_Bootstrap
{
	protected function _initPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
		$initMenu = new Code_Plugin_InitMenu();
		$front->registerPlugin($initMenu);
	}
	
}