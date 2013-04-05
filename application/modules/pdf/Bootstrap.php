<?php
class Pdf_Bootstrap extends Zend_Application_Module_Bootstrap
{
	protected function _initPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
		$initMenu = new Pdf_Plugin_InitMenu();
		$front->registerPlugin($initMenu);
	}
	
}