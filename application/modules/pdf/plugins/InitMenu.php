<?php
class Pdf_Plugin_InitMenu extends Zend_Controller_Plugin_Abstract
{
	public function routeShutdown(Zend_Controller_Request_Abstract $request) {
		if ($request->getModuleName() == 'pdf') {
			$front = Zend_Controller_Front::getInstance();
			$bootstrap = $front->getParam('bootstrap');
	        $view = $bootstrap->getResource('view');
			array_push($view->position_7, Pdf_Model_MainMenu::getMenu());
		}
	}
}