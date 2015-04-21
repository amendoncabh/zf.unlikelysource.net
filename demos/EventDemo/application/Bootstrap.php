<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initOptions()
	{
		Zend_Registry::set('options', $this->getOptions());
	}
	
}

