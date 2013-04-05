<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoload() 
	{
	    $moduleLoader = new Zend_Application_Module_Autoloader(array(
	        'namespace' => 'Application',
	        'basePath' => APPLICATION_PATH));
	    return $moduleLoader;
	}

  protected function _initViewHelpers()
  {
      $this->bootstrap('layout');
      $layout = $this->getResource('layout');
      $view = $layout->getView();
    
      $view->doctype('XHTML1_STRICT');
      $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
      $view->headTitle()->setSeparator(' - ');
      $view->headTitle('unlikelysource.com PHP Code Archive');
  }

  protected function _initSession()
  {
      Zend_Session::start();
  }

  protected function _initAcl()
  {
	  $acl = new Application_Model_Acl();
  	  Zend_Registry::set('acl', $acl);
  }

  protected function _initPlugins()
  {
  	$front = Zend_Controller_Front::getInstance();
  	$front->registerPlugin(new Application_Plugin_Aclplugin());
  }
  
  protected function _initMenus()
  {
      // create cache object
      $cacheOptions = $this->getOption('cache');
	  $frontendOptions = array('lifetime' => 7200, 'automatic_serialization' => true);
	  $backendOptions = array('cache_dir' => $cacheOptions['dir']);
	  $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

	  if (!$aclMenu = $cache->load('aclMenu')) {
	  	  $aclMenu = Application_Model_Aclmenu::getAclMenu();
          $cache->save($aclMenu, 'aclMenu');
	  }
	  if (!$aclPlugin = $cache->load('aclPlugin')) {
	  	  $aclPlugin = Application_Model_Aclplugin::getAclPlugin();
          $cache->save($aclPlugin, 'aclPlugin');
	  }
      Zend_Registry::set('aclMenu', $aclMenu);
      Zend_Registry::set('aclPlugin', $aclPlugin);
  }
	
}
