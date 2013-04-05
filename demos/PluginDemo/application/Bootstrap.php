<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initMenu()
	{
		$config = $this->getOption('navigation');
        $menu  = new Zend_Navigation($config);
		Zend_Registry::set('Zend_Navigation', $menu);
	}
	
	protected function _initViewbase()
	{
        $this->bootstrap('view');
        $view = $this->getResource('view');
        // add a view variable "viewbase"
        $value = '<h3>--------> BOOTSTRAP.PHP</h3>';
        $view->viewbase = $value;
        return $value;
	}

}
