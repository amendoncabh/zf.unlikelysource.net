<?php
class Code_Plugin_InitMenu extends Zend_Controller_Plugin_Abstract
{
	public function routeShutdown(Zend_Controller_Request_Abstract $request) {
		if ($request->getModuleName() == 'code') {
			$front = Zend_Controller_Front::getInstance();
			$bootstrap = $front->getParam('bootstrap');
	        $view = $bootstrap->getResource('view');
			array_push($view->position_7, Code_Model_MainMenu::getMenu());
		}
	}
}