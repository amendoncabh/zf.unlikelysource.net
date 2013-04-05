<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initOptions()
	{
		Zend_Registry::set('options', $this->getOptions());
	}
	
    protected function _initTopMenu()
	{
        $this->bootstrap('view');
        $view = $this->getResource('view');
		$view->position_1 = array(Application_Model_TopMenu::getMenu());
		$view->position_7 = array(Application_Model_MainMenu::getMenu());
	}

}
