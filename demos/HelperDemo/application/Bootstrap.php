<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Demo',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }
    
    protected function _initHelper()
    {
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/controllers/helpers');
    }
    
    protected function _initOptions()
    {
    	Zend_Registry::set('options', $this->getOptions());
    }
	
}

