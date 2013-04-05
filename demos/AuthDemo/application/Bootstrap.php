<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/**
	*
	* This puts the application.ini setting in the registry
	*/
    protected function _initConfig()
    {
        Zend_Registry::set('config', $this->getOptions());
        Zend_Registry::set('acl', new Application_Model_Acl());
    }

    /**
	*
	* This function initializes routes so that http://host_name/login
	* and http://host_name/logout is redirected to the user controller.
	*
	* There is also a dynamic route for clean callback urls for the login
	* providers
	*/
    protected function _initRoutes()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $route = new Zend_Controller_Router_Route('login/:provider',
                                                  array(
                                                  'controller' => 'user',
                                                  'action' => 'login'
                                                  ));
        $router->addRoute('login/:provider', $route);

        $route = new Zend_Controller_Router_Route_Static('login',
                                                         array(
                                                         'controller' => 'user',
                                                         'action' => 'login'
                                                         ));
        $router->addRoute('login', $route);

        $route = new Zend_Controller_Router_Route_Static('logout',
                                                         array(
                                                         'controller' => 'user',
                                                         'action' => 'logout'
                                                         ));
        $router->addRoute('logout', $route);
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
		
	protected function _initAuthUrls()
	{
	    //$this->bootstrap('layout');
	    $layout = $this->getResource('layout');
	    $view = $layout->getView();
		$config = $this->getOptions();
		$view->googleAuthUrl = $config['google']['auth_url'];    
		$view->twitterAuthUrl = $config['twitter']['auth_url'];    
		$view->facebookAuthUrl = $config['facebook']['auth_url'];    
	}
		
	protected function _initSession()
	{
	    Zend_Session::start();
	}

}

